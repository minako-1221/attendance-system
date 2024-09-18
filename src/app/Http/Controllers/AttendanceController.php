<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\BreakRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();

        $date = $request->input('date', Carbon::today()->toDateString());

        DB::enableQueryLog();

        $attendanceRecords = AttendanceRecord::whereDate('clock_in', $date)
            ->with('user', 'breakRecords')->paginate(5);

        return view('attendance', compact('user', 'attendanceRecords', 'date'));
    }

}
