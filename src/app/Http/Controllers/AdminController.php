<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\BreakTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\CarbonPeriod;

class AdminController extends Controller
{
    public function list(Request $request)
    {
        $month = $request->input('month');

        if ($month) {
        $currentMonth = Carbon::parse($month);
        } else {
        $currentMonth = Carbon::now();
        }

        $attendances = Attendance::with(['user', 'breakTimes'])
            ->whereYear('start_datetime', $currentMonth->year)
            ->whereMonth('start_datetime', $currentMonth->month)
            ->get();

        foreach ($attendances as $attendance) {

        $totalBreak = 0;

            foreach    ($attendance->breakTimes as $break) {
                if ($break->break_end) {
                    $totalBreak += Carbon::parse($break->break_end)
                    ->diffInMinutes($break->break_start);
                }
            }

            $attendance->break_total = $totalBreak;
        }

        $prevMonth = $currentMonth->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');

        return view('auth.admin-attendance-list', compact(
        'attendances',
        'currentMonth',
        'prevMonth',
        'nextMonth',
        ));
    }

    //スタッフ一覧
    public function staff(Request $request)
    {
        $users = User::where('id', '!=', 1)->get(); 
        $currentMonth = Carbon::now();

        $attendances = Attendance::with('user')->get(); 

        $prevMonth = $currentMonth->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');

        return view('auth.admin-staff-list', compact(
            'attendances',
            'currentMonth',
            'prevMonth',
            'nextMonth',
            'users'
        ));
    }
    
    //勤怠詳細
    public function adminAttendance($id)
    {
        $attendance = Attendance::with('breakTimes')->findOrFail($id);

        return view('auth.admin-attendance-detail', compact('attendance'));
    }
    public function adminUpdate(Request $request, $id)
    {    
        $attendance = Attendance::findOrFail($id);

        $attendance->update([
            'start_datetime' => Carbon::parse($attendance->start_datetime)->format('Y-m-d') . ' ' . $request->start_time,
            'end_datetime' => $request->end_time
            ? Carbon::parse($attendance->start_datetime)->format('Y-m-d') . ' ' . $request->end_time
            : null,
            'remarks' => $request->remarks,
        ]);

        $user = $attendance->user;
        $name = $attendance->user->name;

        $month = $request->input('month', now()->format('Y-m'));
        $currentMonth = Carbon::parse($month);

        $prevMonth = $currentMonth->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');

        $attendances = Attendance::with('breakTimes')
            ->where('user_id', $id)
            ->whereYear('start_datetime', $currentMonth->year)
            ->whereMonth('start_datetime', $currentMonth->month)
            ->get();

        foreach ($attendances as $attendance) {

            $totalBreak = 0;

            foreach ($attendance->breakTimes as $break) {
                if ($break->break_end) {
                    $totalBreak += Carbon::parse($break->break_end)
                        ->diffInMinutes($break->break_start);
                }
            }
        }

        return redirect()->route('admin.list');
    }

    //スタッフ詳細(月次詳細)
    public function staffDetail(Request $request, $id)
    {    
    $user = User::findOrFail($id);

    $month = $request->input('month', now()->format('Y-m'));
    $currentMonth = Carbon::parse($month);

    $start = $currentMonth->copy()->startOfMonth();
    $end = $currentMonth->copy()->endOfMonth();

    $prevMonth = $currentMonth->copy()->subMonth()->format('Y-m');
    $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');

    $attendances = Attendance::with('breakTimes')
        ->where('user_id', $id)
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
            $monthlyData[] = $attendances[$dateStr];
        } else {
            $monthlyData[] = (object)[
                'id' => 'empty-' . $dateStr,
                'date' => $dateStr,
                'start_datetime' => null,
                'end_datetime' => null,
                'break_total' => 0,
                'work_time' => null,
                'is_empty' => true
            ];
        }
    }

    // 休憩時間計算
    foreach ($attendances as $attendance) {
        $totalBreak = 0;

        foreach ($attendance->breakTimes as $break) {
            if ($break->break_end) {
                $totalBreak += Carbon::parse($break->break_end)
                    ->diffInMinutes($break->break_start);
            }
        }

        $attendance->break_total = $totalBreak;
    }

    return view('auth.admin-attendance-staff', compact(
        'user',
        'monthlyData',
        'month',
        'prevMonth',
        'nextMonth',
        'currentMonth'
    ));
}
    //申請
    public function approve(Request $request)
{
    $status = $request->input('status', 0);

    $attendances = Attendance::with(['user', 'breakTimes'])
        ->where('status', $status)
        ->get();

    return view('auth.admin-stamp-correction-request-list', compact('attendances', 'status'));
}
    //承認申請画面
    public function approvalDetail($attendance_correct_request_id)
{
    $attendance = Attendance::with(['user', 'breakTimes'])
        ->findOrFail($attendance_correct_request_id);

    $name = Auth::user()->name;

    return view('auth.admin-approval-detail', compact('attendance', 'name'));
}
    //申請承認
    public function approvalUpdate(Request $request, $attendance_correct_request_id)
{
    $attendance = Attendance::findOrFail($attendance_correct_request_id);

    $attendance->status = 1;
    $attendance->save();

    return redirect()->route('stamp-correction-request-list', ['status' => 1]);
}
}
