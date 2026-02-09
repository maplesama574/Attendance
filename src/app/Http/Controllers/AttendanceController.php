<?php

namespace App\Http\Controllers;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('auth.attendance');
    }
}
