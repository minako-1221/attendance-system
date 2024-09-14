<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;

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

    Route::get('/attendance', [AttendanceController::class, 'show']);

    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('clock.in');

    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('clock.out');

    Route::post('/attendance/break-start', [AttendanceController::class, 'breakStart'])->name('break.start');

    Route::post('/attendance/break-end', [AttendanceController::class, 'breakEnd'])->name('break.end');
});

