@extends('auth.common4')

@section('css')
<link rel="stylesheet" href="{{asset('css/admin-attendance-list.css')}}">
@endsection

@section('content')
    <div class="attendance">
        <div class="title">
            <p class="title-message"> 勤怠一覧</p>
        </div>
        <div class="page">
            <a class="previous-month" href="{{ route('admin.list', ['month' => $prevMonth]) }}">←前月</a>
            <p class="date">📅{{ $currentMonth->format('Y年m月') }}</p>
            <a class="next-month" href="{{ route('admin.list', ['month' => $nextMonth]) }}">次月→</a>
        </div>
        <div class="table">
            <table class="attendance-table">
                <form action="GET" action="{{route('admin.list')}}">
                        <tr class="table-header">
                            <th class="header-item">名前</th>
                            <th class="header-item">出勤</th>
                            <th class="header-item">退勤</th>
                            <th class="header-item">休憩</th>
                            <th class="header-item">合計</th>
                            <th class="header-item">詳細</th>
                        </tr>
                        @foreach($attendances as $attendance)
                            <tr class="content">
                                <td class="content-item">{{ optional($attendance->user)->name }}</td>
                                <td class="content-item">{{ \Carbon\Carbon::parse($attendance->start_datetime)->format('H:i') }}</td>
                                <td class="content-item">{{ $attendance->end_datetime ? \Carbon\Carbon::parse($attendance->end_datetime)->format('H:i') : '' }}</td>
                                <td class="content-item">
                                    @php
                                        $hours = floor($attendance->break_total / 60);
                                        $minutes = $attendance->break_total % 60;
                                    @endphp
                                    {{ sprintf('%02d:%02d', $hours, $minutes) }}
                                </td>
                                <td class="content-item">
                                    {{ $attendance->work_time }}
                                </td>
                                <td class="content-detail">
                                    <a href="{{ route('admin.attendance', ['id' => $attendance->id]) }}">詳細</a>
                                </td>
                            </tr>
                        @endforeach
                </form>
            </table>
        </div>
    </div>
@endsection