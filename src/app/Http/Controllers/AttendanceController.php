<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\BreakRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class AttendanceController extends Controller
{
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

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 5;
        $currentItems = $attendanceRecords->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $attendanceRecords = new LengthAwarePaginator($currentItems, $attendanceRecords->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        if ($request->ajax()) {
            return view('_records', compact('attendanceRecords', 'users'));
        }

        return view('attendance', compact('users', 'attendanceRecords', 'date'));
    }

}