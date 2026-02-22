<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        Attendance::create([
        'start_datetime' => now(),
        'user_id'=>Auth::id(),
        ]);
        $items=Attendance::all();
        foreach ($items as $item){
            $date = date_create($item->date);
            $date = date_format($date , 'Y-m-d');
            $item->date = $date;
        }
        $isStarted=true;

        $startDate=Carbon::parse($request->start_date);
        $startTime=Carbon::parse($request->start_time);

        return view('auth.attendance', compact('isStarted'));
    }

    public function list(Request $request)
    {
        return view('auth.attendance-list');
    }

    public function detail(Request $request)
    {
        return view('auth.attendance-detail');
    }

    public function stamp(Request $request)
    {
        return view ('auth.stamp-correction-request-list');
    }
}
