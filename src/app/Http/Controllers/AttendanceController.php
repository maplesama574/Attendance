<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\BreakTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod;


class AttendanceController extends Controller
{
    //出勤前
    public function index(Request $request)
    {
        $attendance = Attendance::where('user_id', Auth::id())
            ->latest()
            ->first();

        return view('auth.attendance', compact('attendance'));
    }
    public function indexCreate(Request $request)
    {
        $today = now()->toDateString();

        $alreadySave = Attendance::where('user_id', Auth::id())
            ->whereDate('start_datetime', $today)
            ->exists();
        
        if ($alreadySave){
            return back();
        };
        Attendance::create([
        'start_datetime' => now(),
        'user_id'=>Auth::id(),
        'status' => 0,
        ]);

        return redirect()->route('attendance.in');
    }

    //出勤
    public function attendance(Request $request){
        return view('auth.in');
    }

    //休憩と退勤分岐
    public function action(Request $request)
    {
        $action = $request->input('action'); 

        $attendance = Attendance::where('user_id', Auth::id())
            ->latest()
            ->first();
        
        if(!$attendance){
            return back();
        }

        if ($action === 'break') {

        BreakTime::create([
        'attendance_id' => $attendance->id,
        'break_start' => now(),
        ]);

        return redirect()->route('attendance.break');
        }

        if ($action === 'finish') {

        $attendance->end_datetime = now();
        $attendance->save();

        return redirect()->route('attendance.out');
        }

    return back();

    }

    //休憩開始
    public function breakCreate()
    {
        return view('auth.break');
    }

    //休憩終了
    public function breakEnd()
    {
        $attendance = Attendance::where('user_id', Auth::id())
            ->latest()
            ->first();

        $break = BreakTime::where('attendance_id', $attendance->id)
        ->whereNull('break_end')
        ->latest()
        ->first();
        
        if ($break) {
        $break->break_end = now();
        $break->save();
        }

        return redirect()->route('attendance.in');
    }

    //退勤済
    public function finishCreate()
    {
        return view('auth.out');
    }

    //勤怠一覧
    public function list(Request $request)
{
    $month = $request->input('month');

    $currentMonth = $month
        ? Carbon::parse($month)
        : Carbon::now();

    $start = $currentMonth->copy()->startOfMonth();
    $end = $currentMonth->copy()->endOfMonth();

    $attendances = Attendance::with('breakTimes')
        ->where('user_id', Auth::id())
        ->whereBetween('start_datetime', [$start, $end])
        ->get()
        ->keyBy(function ($item) {
            return Carbon::parse($item->start_datetime)->format('Y-m-d');
        });
        

    $dates = CarbonPeriod::create($start, $end);
    $monthlyData = [];

    foreach ($dates as $date) {
        $dateStr = $date->format('Y-m-d');

        if (isset($attendances[$dateStr])) {
            $attendance = $attendances[$dateStr];

            // 🔹休憩時間
            $totalBreak = 0;
            foreach ($attendance->breakTimes as $break) {
                if ($break->break_start && $break->break_end) {
                    $totalBreak += Carbon::parse($break->break_end)
                        ->diffInMinutes($break->break_start);
                }
            }

            // 🔹勤務時間
            if ($attendance->start_datetime && $attendance->end_datetime) {
                $workTime = Carbon::parse($attendance->end_datetime)
                    ->diffInMinutes($attendance->start_datetime);

                $attendance->work_time = $workTime - $totalBreak;
            } else {
                $attendance->work_time = null;
            }

            $attendance->break_total = $totalBreak;

            $monthlyData[] = $attendance;

        } else {
            $monthlyData[] = (object)[
                'date' => $dateStr,
                'start_datetime' => null,
                'end_datetime' => null,
                'break_total' => 0,
                'work_time' => null,
                'id' => null,
            ];
        }
    }

    $prevMonth = $currentMonth->copy()->subMonth()->format('Y-m');
    $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');

    return view('auth.attendance-list', compact(
        'monthlyData',
        'currentMonth',
        'prevMonth',
        'nextMonth',
    ));
}
    //勤怠詳細
        public function detail($id)
    {
        $attendance = Attendance::with('breakTimes')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $name = Auth::user()->name;

        return view('auth.attendance-detail', compact('attendance','name'));
    }
        public function update(Request $request, $id)
    {
        $attendance = Attendance::with('breakTimes')->findOrFail($id);

        $attendance->update([
            'start_datetime' => Carbon::parse($attendance->start_datetime->format('Y-m-d').' '.$request->start_time),
            'end_datetime' => Carbon::parse($attendance->start_datetime->format('Y-m-d').' '.$request->end_time),
            'remarks' => $request->remarks,
        ]);

        $breakStarts = $request->input('break_start', []);
        $breakEnds = $request->input('break_end', []);

        foreach ($attendance->breakTimes as $index => $break) {

            if (!empty($breakStarts[$index]) && !empty($breakEnds[$index])) {
                $break->update([
                'break_start' => $breakStarts[$index],
                'break_end' => $breakEnds[$index],
                ]);
            }
        }

        return redirect()->route('attendance.list');
    }

//勤怠承認
    public function stamp(Request $request)
{
    $status = $request->input('status', 0);

    if (auth()->user()->is_admin) {

        $attendances = Attendance::with(['user', 'breakTimes'])
            ->where('status', $status)
            ->get();

        return view('auth.admin-stamp-correction-request-list', compact('attendances', 'status'));
    }

    $attendances = Attendance::with(['user', 'breakTimes'])
        ->where('user_id', Auth::id())
        ->where('status', $status)
        ->get();

    return view('auth.stamp-correction-request-list', compact('attendances', 'status'));
}
    //勤怠承認詳細
    public function approvalDetail($id)
    {
        $attendance = Attendance::with('breakTimes')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $name = Auth::user()->name;

        return view('auth.approval-detail', compact('attendance', 'name'));
    }   
    public function updateDetail(Request $request, $id)
    {
        $attendance = Attendance::with('breakTimes')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

    $attendance->update([
        'start_datetime' => Carbon::parse($attendance->start_datetime->format('Y-m-d').' '.$request->start_time),
        'end_datetime' => Carbon::parse($attendance->start_datetime->format('Y-m-d').' '.$request->end_time),
        'remarks' => $request->remarks,
    ]);

    $breakStarts = $request->input('break_start', []);
    $breakEnds = $request->input('break_end', []);

    foreach ($attendance->breakTimes as $index => $break) {

        if (!empty($breakStarts[$index]) && !empty($breakEnds[$index])) {
                $break->update([
                'break_start' => $breakStarts[$index],
                'break_end' => $breakEnds[$index],
            ]);
        }
        }
        foreach ($breakStarts as $index => $start) {

    if (!empty($start) && !empty($breakEnds[$index])) {

        if (!isset($attendance->breakTimes[$index])) {
            BreakTime::create([
                'attendance_id' => $attendance->id,
                'break_start' => $start,
                'break_end' => $breakEnds[$index],
            ]);
        }
    }
}
        return redirect()->route('approval-detail', $attendance->id);
    }
}
