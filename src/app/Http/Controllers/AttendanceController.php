<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\BreakRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function clockIn(Request $request)
    {
        $user = Auth::user();

        $currentTime = Carbon::now();

        AttendanceRecord::create([
            'user_id' => $user->id,
            'clock_in' => $currentTime,
        ]);

        return redirect()->back();
    }

    public function clockOut(Request $request)
    {
        $user = Auth::user();

        $attendanceRecords = AttendanceRecord::where('user_id', $user->id)->whereNull('clock_out')->first();

        if ($attendanceRecords) {
            $attendanceRecords->clock_out = Carbon::now();
            $attendanceRecords->clock_total = $attendanceRecords->clock_out->diffInSeconds($attendanceRecords->clock_in);
            $attendanceRecords->save();
        }

        return redirect()->back();
    }

    public function breakStart(Request $request)
    {
        $user = Auth::user();

        $attendanceRecords = AttendanceRecord::where('user_id', $user->id)->whereDate('clock_in', Carbon::today())->first();

        $breakRecords = new BreakRecord();
        $breakRecords->attendance_record_id = $attendanceRecords->id;
        $breakRecords->break_start = Carbon::now();
        $breakRecords->save();

        return redirect()->back();
    }

    public function breakEnd(Request $request)
    {
        $user = Auth::user();

        $attendanceRecords = AttendanceRecord::where('user_id', $user->id)->whereDate('clock_in', Carbon::today())->first();

        $breakRecords = BreakRecord::where('attendance_record_id', $attendanceRecords->id)->whereNull('break_end')->latest('break_start')->first();

        $breakRecords->break_end = Carbon::now();

        $breakRecords->break_total = Carbon::parse($breakRecords->break_start)->diffInSeconds(Carbon::now());

        $breakRecords->save();

        return redirect()->back();
    }
    public function show(Request $request)
    {
        $user = Auth::user();

        $date = $request->input('date', Carbon::today()->toDateString());

        $users = User::with('attendanceRecords.breakRecords')->paginate(5);

        $attendanceRecords = AttendanceRecord::whereDate('clock_in', $date)
            ->with('user','breakRecords');

        if($request->ajax()){
            return view('_records', compact('attendanceRecords','users'));
        }

        return view('attendance', compact('users', 'attendanceRecords','date'));
    }

}