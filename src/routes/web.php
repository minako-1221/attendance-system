<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\EmailVerification;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index']);

    Route::get('/attendance', [AttendanceController::class, 'show'])->name('attendance.records');

    Route::post('/clock-in', [AttendanceController::class, 'clockIn'])->name('clock.in');

    Route::post('/clock-out', [AttendanceController::class, 'clockOut'])->name('clock.out');

    Route::post('/break-start', [AttendanceController::class, 'breakStart'])->name('break.start');

    Route::post('/break-end', [AttendanceController::class, 'breakEnd'])->name('break.end');

    //Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        //->middleware(['auth', 'signed'])
        //->name('verification.verify');
});

//Route::get('/email/verify', function () {
    //return view('auth.verify-email'); // 確認メッセージを表示するためのビュー
//})->name('verification.notice');

//Route::get('/test-email/{userId}', function ($userId) {
    // 指定されたIDのユーザーを取得
    //$user = User::find($userId); // IDに基づいてユーザーを取得

    //if (!$user) {
        //return 'ユーザーが見つかりません。';
    //}

    //try {
        // メールの内容を生成
        //Mail::to($user->email)->send(new EmailVerification($user));
        //return 'Verification email sent!';
    //} catch (\Exception $e) {
        //return 'メール送信に失敗しました: ' . $e->getMessage();
    //}
//});