<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\BreakRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function clockIn(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();

        $currentTime = Carbon::now();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)
            ->whereDate('clock_in', $today)
            ->first();

        if (!$attendanceRecord) {
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
        }

        return redirect('/');
    }

    public function clockOut(Request $request)
    {
        $user = Auth::user();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)->whereDate('clock_in', Carbon::today())->first();

        if ($attendanceRecord) {
            $currentTime = Carbon::now();
            $attendanceRecord->clock_out = $currentTime;

            $attendanceRecord->save();
        }

        session([
            'clock_in' => false,
            'clock_out' => true,
            'break_start' => false,
            'break_end' => false,
            'last_date' => Carbon::today()->toDateString(),
        ]);

        return redirect('/');
    }

    public function breakStart(Request $request)
    {
        $user = Auth::user();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)->whereDate('clock_in', Carbon::today())->first();

        $breakRecord = new BreakRecord();
        $breakRecord->attendance_record_id = $attendanceRecord->id;
        $breakRecord->break_start = Carbon::now();

        $breakRecord->save();

        session([
            'clock_in' => false,
            'clock_out' => false,
            'break_start' => true,
            'break_end' => false,
            'last_date' => Carbon::today()->toDateString(),
        ]);

        return redirect('/');
    }

    public function breakEnd(Request $request)
    {
        $user = Auth::user();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)->whereDate('clock_in', Carbon::today())->first();

        $breakRecord = BreakRecord::where('attendance_record_id', $attendanceRecord->id)
            ->whereDate('break_start', Carbon::today())
            ->whereNull('break_end')
            ->latest('break_start')
            ->first();

        if ($breakRecord) {
            $currentTime = Carbon::now();
            $breakRecord->break_end = $currentTime;

            $breakRecord->save();
        }

        session([
            'clock_in' => false,
            'clock_out' => false,
            'break_start' => false,
            'break_end' => true,
            'last_date' => Carbon::today()->toDateString(),
        ]);

        return redirect('/');
    }

    public function show(Request $request)
    {
        $user = Auth::user();

        $date = $request->input('date', Carbon::today()->toDateString());
        $page = $request->input('page', 1);

        $users = User::with([
            'attendanceRecords' => function ($query) use ($date) {
                $query->whereDate('clock_in', $date)->with('breakRecords');
            }
        ])->paginate(5)->appends(['date' => $date]);

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)
            ->whereDate('clock_in', $date)
            ->with('user', 'breakRecords')
            ->first();

        if ($request->ajax()) {
            return view('_records', compact('attendanceRecord', 'users', 'date'));
        }

        return view('attendance', compact('users', 'attendanceRecord', 'date'));
    }

}