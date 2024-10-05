<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\BreakRecord;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function clockIn(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)
            ->whereDate('clock_in', $today)
            ->first();

        if($attendanceRecord){
            return redirect('/');
        }

        $currentTime = Carbon::now();

        $attendanceRecord = AttendanceRecord::create([
            'user_id' => $user->id,
            'clock_in' => $currentTime,
        ]);

        session([
            'clock_in' => true,
            'clock_out' => false,
            'break_start' => false,
            'break_end' => false,
            'last_date' => $today->toDateString(),
        ]);

        return redirect('/');
    }

    public function clockOut(Request $request)
    {
        $user = Auth::user();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)->whereNull('clock_out')->first();

        if ($attendanceRecord) {
            $attendanceRecord->clock_out = Carbon::now();
            $attendanceRecord->clock_total = $attendanceRecord->clock_out->diffInSeconds($attendanceRecord->clock_in);
            $attendanceRecord->save();

            session([
                'clock_in' => false,
                'clock_out' => true,
                'break_start' => false,
                'break_end' => false,
                'last_date' => Carbon::today()->toDateString(),
            ]);
        }

        return redirect('/');
    }

    public function breakStart(Request $request)
    {
        $user = Auth::user();

        $attendanceRecords = AttendanceRecord::where('user_id', $user->id)->whereDate('clock_in', Carbon::today())->first();

        $breakRecords = new BreakRecord();
        $breakRecords->attendance_record_id = $attendanceRecords->id;
        $breakRecords->break_start = Carbon::now();
        $breakRecords->save();

        return redirect('/');
    }

    public function breakEnd(Request $request)
    {
        $user = Auth::user();

        $attendanceRecords = AttendanceRecord::where('user_id', $user->id)->whereDate('clock_in', Carbon::today())->first();

        $breakRecords = BreakRecord::where('attendance_record_id', $attendanceRecords->id)->whereNull('break_end')->latest('break_start')->first();

        $breakRecords->break_end = Carbon::now();

        $breakRecords->break_total = Carbon::parse($breakRecords->break_start)->diffInSeconds(Carbon::now());

        $breakRecords->save();

        return redirect('/');
    }

    public function show(Request $request)
    {
        $user = Auth::user();

        $date = $request->input('date', Carbon::today()->toDateString());

        $users = User::with([
            'attendanceRecords' => function ($query) use ($date) {
                $query->whereDate('clock_in', $date)->with('breakRecords');
            }
        ])->paginate(5);

        $cacheKey = 'attendance_records_' . $date;

        $attendanceRecords = Cache::remember($cacheKey, 1800, function () use ($date) {
            return AttendanceRecord::whereDate('clock_in', $date)
                ->with('user', 'breakRecords')->get();
        });

        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $attendanceRecords->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedAttendanceRecords = new LengthAwarePaginator($currentItems, $attendanceRecords->count(), $perPage, $currentPage);

        if ($request->ajax()) {
            return view('_records', compact('paginatedAttendanceRecords', 'users'));
        }
        return view('attendance', compact('users', 'paginatedAttendanceRecords', 'date'));
    }

}