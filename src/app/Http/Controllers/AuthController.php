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

        // 前日のButtonStateを削除（翌日には無効にする）
        ButtonState::where('user_id', $user->id)
            ->where('date', '<', $today) // 昨日以前のデータを削除
            ->delete();

        $defaultStates = [
            'clock_in' => false,
            'clock_out' => false,
            'break_start' => false,
            'break_end' => false,
        ];

        // ボタン状態をDBから取得（存在しない場合は null）
        $buttonStates = ButtonState::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        // レコードが存在しない場合は初期状態を表示用に設定
        if (!$buttonStates) {
            $buttonStates = (object) $defaultStates;
        }

        return view('index', compact('user', 'buttonStates'));
    }
}
