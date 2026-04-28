<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Contracts\LoginViewResponse;


Route::get('/', function () {
    return view('welcome');
});

//ユーザー権限　各種機能
Route::middleware(['auth', 'verified'])->group(function () {
    //ホーム
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');    
    Route::post('/attendance/save', [AttendanceController::class, 'indexCreate'])->name('attendance.save');

    //分岐
    Route::get('/attendance/in', [AttendanceController::class, 'attendance'])->name('attendance.in');
    Route::post('/attendance/action', [AttendanceController::class, 'action'])->name('attendance.action');

    //休憩
    Route::get('/attendance/break', [AttendanceController::class, 'breakCreate'])->name('attendance.break');
    Route::post('/attendance/break/end',[AttendanceController::class,'breakEnd'])->name('attendance.break.end');
    
    //退勤
    Route::get('/attendance/out', [AttendanceController::class, 'finishCreate'])->name('attendance.out');


    //勤怠一覧
    Route::get('/attendance/list', [AttendanceController::class, 'list'])->name('attendance.list');

    //勤怠詳細
    Route::get('/attendance/detail/{id}', [AttendanceController::class, 'detail'])->name('attendance-detail');
    Route::patch('/attendance/update/{id}', [AttendanceController::class, 'update'])
    ->name('attendance.update');


    //勤怠承認待ち
    Route::get('/stamp_correction_request/list', [AttendanceController::class, 'stamp'])->name('stamp-correction-request-list');
    //勤怠承認詳細
    Route::get('/stamp_correction_request/approval/{id}', [AttendanceController::class, 'approvalDetail'])->name('approval-detail');
    Route::patch('/stamp_correction_request/approval/update/{id}', [AttendanceController::class, 'updateDetail'])->name('approval.update');
    /* ここ下にログイン必要なルーティングを書く */
});

//管理者権限(ログイン)
Route::get('/admin/login', function () {
    return app(LoginViewResponse::class);
})->middleware('guest')->name('admin.login');

Route::middleware('auth', 'admin')->group(function () {
    //勤怠一覧
    Route::get('/admin/attendance/list', [AdminController::class, 'list'])->name('admin.list');
    
    //勤怠詳細
    Route::get('admin/attendance/{id}', [AdminController::class, 'adminAttendance'])->name('admin.attendance');
    Route::patch('admin/attendance/{id}', [AdminController::class, 'adminUpdate'])->name('admin.update');

    //スタッフ一覧
    Route::get('/admin/staff/list', [AdminController::class, 'staff'])->name('admin.staff');

    //スタッフ詳細(勤怠画面　月次)
    Route::get('/admin/attendance/staff/{id}', [AdminController::class, 'staffDetail'])->name('admin.staff-detail');

    //修正申請承認画面
    Route::get('/stamp_correction_request/approve/{attendance_correct_request_id}', [AdminController::class, 'approvalDetail'])->name('admin.approval-detail');

    //修正申請承認を行う画面
    Route::patch('/stamp_correction_request/approve/{attendance_correct_request_id}', [AdminController::class, 'approvalUpdate'])->name('admin.approval-update');
});