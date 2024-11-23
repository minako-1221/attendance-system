<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Actions\Fortify\LoginResponse;
use App\Http\Controllers\Auth\CustomLoginController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LoginResponseContract::class, function () {

            //return new class implements LoginResponseContract {
                //public function toResponse($request)
                //{
                    // 認証済みかどうかを確認
                    //if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
                    //Auth::logout(); // ログアウト

                    //return redirect()->route('verification.notice')
                    //->with('status', 'メール確認が必要です。リンクを確認して再度ログインしてください。');
                    //}

                    return redirect()->route('login'); // ログインページにリダイレクト

                //}
            //};
        });
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::authenticateUsing(function (Request $request) {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'max:255'],
            ]);

            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray());
            }

            $user = \App\Models\User::where('email', $request->email)->first();

            if (!$user) {
                // メールアドレスが登録されていない場合
                throw ValidationException::withMessages([
                    'email' => '会員登録されていないメールアドレスです。',
                ]);
            }

            // パスワードが正しいかチェック
            if (!Hash::check($request->password, $user->password)) {
                // パスワードが間違っている場合
                throw ValidationException::withMessages([
                    'password' => 'パスワードが間違っています。',
                ]);
            }

            // ログインが成功した場合、ユーザーを返す
            return $user;
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

    }
}
