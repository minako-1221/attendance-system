<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    public function verify(Request $request, $id)
    {
        //$user = User::findOrFail($id);

        // 認証されているか、リンクが署名付きか確認
        //if (!$request->hasValidSignature()) {
            //return redirect()->route('login')->with('error', '無効な認証リンクです');
        //}

        //if ($user->id !== Auth::id() || !$request->hasValidSignature()) {
            //Log::warning('不正な認証リンクが試行されました。', ['user_id' => $user->id]);
            //return redirect()->route('login')->with('error', '無効な認証リンクです');
        //}

        // メールがすでに認証済みの場合
        //if ($user->hasVerifiedEmail()) {
            //return redirect()->route('dashboard')->with('status', 'メールは既に認証済みです');
        //}

        // メール認証を完了
        //$user->markEmailAsVerified();

        // メール認証イベントを発火
        //event(new Verified($user));

        //return redirect()->route('dashboard')->with('status', 'メール認証が完了しました');
    }
}
