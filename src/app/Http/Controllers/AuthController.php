<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\BreakRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('index',compact('user'));
    }

    public function clockIn(Request $request)
    {
        $user = Auth::user();

        $currentTime = Carbon::now();

        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
            'clock_in' => $currentTime,
        ]);

        if ($attendance) {
            return redirect()->back()->with('status', 'Clock in successful');
        } else {
            return redirect()->back()->with('error', 'Failed to clock in');
        }
    }

    public function clockOut(Request $request)
    {
        $user = Auth::user();

        $attendanceRecords = AttendanceRecord::where('user_id', $user->id)->whereNull('clock_out')->first();

        if ($attendanceRecords) {
            $attendanceRecords->clock_out = Carbon::now();
            $attendanceRecords->clock_total = $attendanceRecords->clock_out->diffInSeconds($attendanceRecords->clock_in);

            if ($attendanceRecords->save()) {
                return redirect()->back()->with('status', 'Clock out successful');
            } else {
                return redirect()->back()->with('error', 'Failed to clock out');
            }
        }

        return redirect()->back()->with('error', 'No active attendance record found');
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

}
