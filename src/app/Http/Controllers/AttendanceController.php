<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function show()
    {
        $attendanceRecords = AttendanceRecord::with('user','breakRecords')->get();

        return view('attendance',compact('attendanceRecords'));
    }
}
