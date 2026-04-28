@extends('auth.common2')

@section('css')
<link rel="stylesheet" href="{{asset('css/approval-detail.css')}}">
@endsection

@section('content')
    <div class="attendance">
        <form method="POST" action="{{ route('approval.update', $attendance->id) }}">
            @csrf
            @method('PATCH')
            <div class="title">
                <p class="title-message"> 勤怠詳細</p>
            </div>
            <div class="content">
                <table class="table">
                    <tr class="table-content">
                        <th class="table-header">名前</th>
                        <td class="table-detail__name" colspan="3">{{$name}}</td>
                    </tr>
                    <tr class="table-content">
                        <th class="table-header">日付</th>
                        <td class="table-detail">{{ \Carbon\Carbon::parse($attendance->start_datetime)->isoFormat('YYYY年') }}</td>
                        <td class="table-decoration"></td>
                        <td class="table-detail__left">{{ \Carbon\Carbon::parse($attendance->start_datetime)->isoFormat('M月D日') }}</td>
                    </tr>
                    <tr class="table-content">
                        <th class="table-header">出勤・退勤</th>
                        <td class="table-detail">{{ old('start_time', \Carbon\Carbon::parse($attendance->start_datetime)->format('H:i')) }}</td>
                        <td class="table-decoration">～</td>
                        <td class="table-detail__left">{{ old('end_time', $attendance->end_datetime ? \Carbon\Carbon::parse($attendance->end_datetime)->format('H:i') : '') }}
                        </td>
                    </tr>
                    @foreach($attendance->breakTimes as $break)
                    <tr class="table-content">
                        <th class="table-header">
                            @if($loop->iteration == 1)
                                休憩
                            @else
                                休憩{{ $loop->iteration }}
                            @endif
                        </th>
                        <td class="table-detail">
                            {{ old('break_start', optional($break->break_start)->format('H:i')) }}
                        </td>
                        <td class="table-decoration">～</td>
                        <td class="table-detail__left">
                            {{ old('break_end', optional($break->break_end)->format('H:i')) }}
                        </td>
                    </tr>
                    @endforeach
                    <tr class="table-content">
                        <th class="table-header">備考</th>
                        <td class="table-detail__textarea" colspan="3">  
                            {{ old('remarks', $attendance->remarks) }}
                        </td>
                    </tr>
                </table>
                <div class="not-message">
                    <p class="message">*承認待ちのため修正はできません。</p>
                </div>
            </div>
        </form>
    </div>
@endsection