<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    Route::get('/email/verification', [AuthController::class, 'showEmail'])->name('verification.verify');
});

Route::middleware(['auth', 'verfied'])->group(function () {

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    /* ここ下にログイン必要なルーティングを書く */
});
