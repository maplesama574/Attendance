<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $isStarted=true;

        $startDate=Carbon::parse($request->start_date);
        $startTime=Carbon::parse($request->start_time);

        $model->start_datetime=$startDate->format('Y-m-d') . '' . $startTime->format('H:i:s');
        $model->save();

        return view('auth.attendance', compact('isStarted'));
    }
}
