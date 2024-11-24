<?php

namespace App\Http\Controllers;

use App\Models\ButtonState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $today = Carbon::today()->toDateString();

        ButtonState::where('user_id', $user->id)
            ->where('date', '<', $today)
            ->delete();

        $defaultStates = [
            'clock_in' => false,
            'clock_out' => false,
            'break_start' => false,
            'break_end' => false,
        ];

        $buttonStates = ButtonState::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$buttonStates) {
            $buttonStates = (object) $defaultStates;
        }

        return view('index', compact('user', 'buttonStates'));
    }
}
