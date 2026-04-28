@extends('auth.common2')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance-list.css')}}">
@endsection

@section('content')
    <div class="attendance">
        <div class="title">
            <p class="title-message"> 勤怠一覧</p>
        </div>
        <div class="page">
            <a class="previous-month" href="{{ route('attendance.list', ['month' => $prevMonth]) }}">←前月</a>
            <p class="date">📅{{ $currentMonth->format('Y年m月') }}</p>
            <a class="next-month" href="{{ route('attendance.list', ['month' => $nextMonth]) }}">次月→</a>
        </div>
        <div class="table">
            <table class="attendance-table">
                <tr class="table-header">
                    <th class="header-item">日付</th>
                    <th class="header-item">出勤</th>
                    <th class="header-item">退勤</th>
                    <th class="header-item">休憩</th>
                    <th class="header-item">合計</th>
                    <th class="header-item">詳細</th>
                </tr>
                @foreach($monthlyData as $attendance)
                        <tr class="content">
                            <td class="content-item">
                                {{ \Carbon\Carbon::parse($attendance->date ?? $attendance->start_datetime)->format('m/d') }}
                            </td>
                            <td class="content-item">
                                @if($attendance->start_datetime)
                                    {{ \Carbon\Carbon::parse($attendance->start_datetime)->format('H:i') }}
                                @else
                                @endif
                            </td>
                            <td class="content-item">
                                @if($attendance->end_datetime)
                                    {{ \Carbon\Carbon::parse($attendance->end_datetime)->format('H:i') }}
                                @else
                                @endif
                            </td>
                            <td class="content-item">
                                @php
                                    $breakTotal = is_numeric($attendance->break_total ?? null) ? $attendance->break_total : 0;
                                    $hours = floor($breakTotal / 60);
                                    $minutes = $breakTotal % 60;
                                @endphp
                                @if($breakTotal > 0)
                                    {{ sprintf('%02d:%02d', $hours, $minutes) }}
                                @endif
                        </td>
                         <td class="content-item">
                            @if($attendance->start_datetime && $attendance->end_datetime)
                                @php
                                    $start = \Carbon\Carbon::parse($attendance->start_datetime);
                                    $end = \Carbon\Carbon::parse($attendance->end_datetime);

                                    $workTime = $end->diffInMinutes($start);

                                    $breakTotal = 0;
                                        foreach ($attendance->breakTimes as $break) {
                                        if ($break->break_start && $break->break_end) {
                                                $breakTotal += \Carbon\Carbon::parse($break->break_end)
                                                ->diffInMinutes($break->break_start);
                                            }
                                        }
                                    $total = max(0, $workTime - $breakTotal);
                                    $hours = floor($total / 60);
                                    $minutes = $total % 60;
                                @endphp

                            {{ sprintf('%02d:%02d', $hours, $minutes) }}
                            @endif
                            </td>
                            <td class="content-detail">
                                @if(!empty($attendance->id))
                                    <a href="{{ route('attendance-detail', ['id' => $attendance->id]) }}">詳細</a>
                                @else
                                    <p class="detail">詳細</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
            </table>
        </div>
    </div>
@endsection