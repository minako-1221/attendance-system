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
    Route::get('/attendance', [AuthController::class, 'index']);

    Route::get('/records', [AttendanceController::class, 'show'])->name('attendance.records');

    Route::post('/attendance/clock-in', [AuthController::class, 'clockIn'])->name('clock.in');

    Route::post('/attendance/clock-out', [AuthController::class, 'clockOut'])->name('clock.out');

    Route::post('/attendance/break-start', [AuthController::class, 'breakStart'])->name('break.start');

    Route::post('/attendance/break-end', [AuthController::class, 'breakEnd'])->name('break.end');
});

