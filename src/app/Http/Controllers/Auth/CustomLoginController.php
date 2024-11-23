<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\EmailVerification;
use App\Models\User;

class LoginController extends Controller
{
    protected function authenticated(Request $request, $user)
    {
        //if (!$user->hasVerifiedEmail()) {
            //try {
                //Mail::to($user->email)->send(new EmailVerification($user));
            //} catch (\Exception $e) {
                //Log::error('メール送信エラー: ' . $e->getMessage());
                //return redirect()->route('login')->with('error', 'メール送信に失敗しました。再度お試しください。');
            //}

            //Auth::logout();

            //return redirect()->route('verification.notice');
        //}
    }

}
