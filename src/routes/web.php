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

    Route::post('/clock-in', [AuthController::class, 'clockIn'])->name('clock.in');

    Route::post('/clock-out', [AuthController::class, 'clockOut'])->name('clock.out');

    Route::post('/break-start', [AuthController::class, 'breakStart'])->name('break.start');

    Route::post('/break-end', [AuthController::class, 'breakEnd'])->name('break.end');
});

