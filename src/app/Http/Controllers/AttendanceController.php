<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\BreakRecord;
use App\Models\ButtonState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function clockIn(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $attendanceRecord=AttendanceRecord::firstOrCreate(
            ['user_id' => $user->id, 'clock_in' => $today],
            ['clock_in' => Carbon::now()]
        );

        if (!$attendanceRecord) {
            $attendanceRecord = AttendanceRecord::create([
                'user_id' => $user->id,
                'clock_in' => Carbon::now(),
            ]);
        }

        $buttonState = ButtonState::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            ['clock_in' => true, 'clock_out' => false, 'break_start' => false, 'break_end' => false]
        );

        return redirect('/');
    }

    public function clockOut(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)
            ->whereDate('clock_in', $today)
            ->first();

        if ($attendanceRecord && is_null($attendanceRecord->clock_out)) {
            $attendanceRecord->clock_out = Carbon::now();
            $attendanceRecord->save();

            $buttonState = ButtonState::where('user_id', $user->id)
                ->where('date', $today)
                ->first();

            if ($buttonState) {
                $buttonState->update([
                    'clock_in' => false,
                    'clock_out' => true,
                    'break_start' => false,
                    'break_end' => false
                ]);
            }
        }

        return redirect('/');
    }

    public function breakStart(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)
            ->whereDate('clock_in', $today)
            ->first();

        if ($attendanceRecord) {
            $breakRecord = BreakRecord::create([
                'attendance_record_id' => $attendanceRecord->id,
                'break_start' => Carbon::now(),
            ]);

            $buttonState = ButtonState::where('user_id', $user->id)
                ->where('date', $today)
                ->first();

            if ($buttonState) {
                $buttonState->update([
                    'clock_in' => false,
                    'clock_out' => false,
                    'break_start' => true,
                    'break_end' => false
                ]);
            }
        }

        return redirect('/');
    }

    public function breakEnd(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)
            ->whereDate('clock_in', $today)
            ->first();

        $breakRecord = BreakRecord::where('attendance_record_id', $attendanceRecord->id)
            ->whereDate('break_start', Carbon::today())
            ->whereNull('break_end')
            ->latest('break_start')
            ->first();

        if ($breakRecord) {
            $breakRecord->update(['break_end' => Carbon::now()]);

            $buttonState = ButtonState::where('user_id', $user->id)
                ->where('date', $today)
                ->first();

            if ($buttonState) {
                $buttonState->update([
                    'clock_in' => false,
                    'clock_out' => false,
                    'break_start' => false,
                    'break_end' => true
                ]);
            }
        }

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