<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Models\User;

class LoginController extends Controller
{
    protected function authenticated(Request $request, $user)
    {
        //if (!$user->is_verified) {
            // メール送信（カスタムメールクラスを使用する場合）
            //Mail::to($user->email)->send(new EmailVerification($user));

            // ログアウトして認証案内ページへリダイレクト
            //Auth::logout();

            //return redirect()->route('verification.notice')
                //->with('status', 'メールアドレスの確認をお願いします');
        //}
    }

}
