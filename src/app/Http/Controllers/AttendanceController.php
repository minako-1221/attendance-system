<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\BreakRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function show()
    {
        $attendanceRecords = AttendanceRecord::with('user', 'breakRecords')->paginate(5);

        return view('attendance', compact('attendanceRecords'));
    }

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

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)->whereNull('clock_out')->first();

        if ($attendanceRecord) {
            $attendanceRecord->clock_out = Carbon::now();
            $attendanceRecord->clock_total = $attendanceRecord->clock_out->diffInSeconds($attendanceRecord->clock_in);
            $attendanceRecord->save();
        }

        return redirect()->back();
    }

    public function breakStart(Request $request)
    {
        $user = Auth::user();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)->whereDate('clock_in', Carbon::today())->first();

        $breakRecord = new BreakRecord();
        $breakRecord->attendance_record_id = $attendanceRecord->id;
        $breakRecord->break_start = Carbon::now();
        $breakRecord->save();

        return redirect()->back();
    }

    public function breakEnd(Request $request)
    {
        $user = Auth::user();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)->whereDate('clock_in', Carbon::today())->first();

        $breakRecord = BreakRecord::where('attendance_record_id', $attendanceRecord->id)->whereNull('break_end')->latest('break_start')->first();

        $breakRecord->break_end = Carbon::now();

        $breakRecord->break_total = Carbon::parse($breakRecord->break_start)->diff(Carbon::now());

        $breakRecord->save();

        return redirect()->back();
    }
}
