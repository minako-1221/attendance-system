<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $attendanceRecords = AttendanceRecord::with('user')->paginate(5);

        return view('index',compact('user','attendanceRecords'));
    }
}
