@extends('auth.common4')

@section('css')
<link rel="stylesheet" href="{{asset('css/admin-approval-detail.css')}}">
@endsection

@section('content')
    <div class="attendance">
        <form method="POST" action="{{ route('admin.approval-update', ['attendance_correct_request_id' => $attendance->id]) }}">
            @csrf
            @method('PATCH')
            <div class="title">
                <p class="title-message"> 勤怠詳細</p>
            </div>
            <div class="content">
                <table class="table">
                    <tr class="table-content">
                        <th class="table-header">名前</th>
                        <td class="table-detail__name" colspan="3">{{ $attendance->user->name }}</td>
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
                        @if(count($attendance->breakTimes) == 0)
                            休憩
                        @else
                            休憩{{ count($attendance->breakTimes) + 1 }}
                        @endif
                        </th>
                        <td class="table-detail">
                        </td>
                        <td class="table-decoration">～</td>
                        <td class="table-detail__left">
                        </td>
                    </tr>
                    @endforeach
                    <tr class="table-content">
                        <th class="table-header">備考</th>
                        <td class="table-detail__textarea" colspan="3">  
                            {!! nl2br(e(old('remarks', $attendance->remarks))) !!}
                        </td>
                    </tr>
                </table>
                @if($attendance->status === 1)
                    <button class="approved-button" disabled>承認済み</button>
                @else
                    <button class="approval-button" type="submit">承認</button>
                @endif
            </div>
        </form>
    </div>
@endsection