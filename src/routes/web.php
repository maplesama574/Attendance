<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::get('/', function () {
    return view('welcome');
});


//Route::get('/email/verify', function () { return view('auth.email'); })->middleware(['auth'])->name('verification.notice'); 


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::get('/attendance/list', [AttendanceController::class, 'list'])->name('attendance-list');
    Route::get('/attendance/detail/{id}', [AttendanceController::class, 'detail'])->name('attendance-detail');
    Route::get('/stamp_correction_request/list', [AttendanceController::class, 'stamp'])->name('stamp-correction-request-list');
    /* ここ下にログイン必要なルーティングを書く */
});
