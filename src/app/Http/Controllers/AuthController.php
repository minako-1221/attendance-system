<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\BreakRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $attendanceRecord = AttendanceRecord::where('user_id', $user->id)->whereDate('clock_in',$today)->first();

        return view('index',compact('user','attendanceRecord'));
    }

}
