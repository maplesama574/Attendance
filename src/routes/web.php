<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::get('/register', [AuthController::class, 'showRegister']);

    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
});

Route::middleware(['auth', 'verfied'])->group(function () {

    Route::get('/email/verification', [AttendanceController::class, 'index'])->name('verification.verify');

    Route::get('/attendance', [AttendanceController::class, 'index']);
    /* ここ下にログイン必要なルーティングを書く */
});
