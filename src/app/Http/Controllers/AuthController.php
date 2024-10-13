<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        $sessionDate = session('last_date', null);

        if ($sessionDate !== $today) {
            session([
                'clock_in' => false,
                'clock_out' => false,
                'break_start' => false,
                'break_end' => false,
                'last_date' => $today,
            ]);
        }

        $buttonStates = [
            'clock_in' => session('clock_in', false),
            'clock_out' => session('clock_out', false),
            'break_start' => session('break_start', false),
            'break_end' => session('break_end', false),
        ];

        return view('index', compact('user', 'buttonStates'));
    }

}
