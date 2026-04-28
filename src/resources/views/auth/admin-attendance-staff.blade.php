@extends('auth.common4')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance-list.css')}}">
@endsection

@section('content')
    <div class="attendance">
        <div class="title">
            <p class="title-message"> 勤怠一覧</p>
        </div>
        <div class="page">
            <a class="previous-month" href="{{ route('admin.staff-detail', [
                    'id' => $user->id,
                    'month' => $prevMonth
                    ]) }}">←前月</a>
            <p class="date">📅{{ $currentMonth->format('Y年m月') }}</p>
            <a class="next-month" href="{{ route('admin.staff-detail', [
                    'id' => $user->id,
                    'month' => $nextMonth
                    ]) }}">次月→</a>
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
                        <td class="content-item"> {{ \Carbon\Carbon::parse($attendance->date)->isoFormat('MM月DD日(ddd)') }}</td>
                        <td class="content-item">
                            {{ $attendance->start_datetime 
                            ? \Carbon\Carbon::parse($attendance->start_datetime)->format('H:i') 
                            : '' }}
                        </td>
                        <td class="content-item">
                            {{ $attendance->end_datetime 
                            ? \Carbon\Carbon::parse($attendance->end_datetime)->format('H:i') 
                            : '' }}
                        </td>
                        <td class="content-item">
                            @if(empty($attendance->is_empty))
                                @php
                                    $break = $attendance->break_total ?? 0;
                                    $hours = floor($break / 60);
                                    $minutes = $break % 60;
                                @endphp
                                    {{ sprintf('%02d:%02d', $hours, $minutes) }}
                                @else
                                    
                                @endif
                        </td>
                        <td class="content-item">
                            {{ empty($attendance->is_empty) ? $attendance->work_time : '' }}
                        </td>
                        <td class="content-detail">
                            @if(empty($attendance->is_empty))
                                <a href="{{ route('admin.attendance', ['id' => $attendance->id]) }}">
                                    詳細
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection