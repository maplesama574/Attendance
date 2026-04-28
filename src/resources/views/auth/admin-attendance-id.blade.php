@extends('auth.common2')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance-detail.css')}}">
@endsection

@section('content')
    <div class="attendance">
        <form method="POST" action="{{ route('admin.attendance', $attendance->id) }}">
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
                        <td class="table-detail"><input class="icon-del" type="time" name="start_time"
                        value="{{ old('start_time', \Carbon\Carbon::parse($attendance->start_datetime)->format('H:i')) }}"></td>
                        <td class="table-decoration">～</td>
                        <td class="table-detail__left"><input class="icon-del" type="time" name="end_time"
                        value="{{ old('end_time', $attendance->end_datetime ? \Carbon\Carbon::parse($attendance->end_datetime)->format('H:i') : '') }}">
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
                            <input type="time" name="break_start[]" class="icon-del"
                            value="{{ old('break_start', optional($break->break_start)->format('H:i')) }}">
                        </td>
                        <td class="table-decoration">～</td>
                        <td class="table-detail__left">
                            <input type="time" name="break_end[]" class="icon-del"
                            value="{{ old('break_end', optional($break->break_end)->format('H:i')) }}">
                        </td>
                    </tr>
                    @endforeach
                    <tr class="table-content">
                        <th class="table-header">備考</th>
                        <td class="table-detail" colspan="3">
                        <textarea class="table-detail__textarea" name="remarks" id="remarks">
                            {{ old('remarks', $attendance->remarks) }}
                        </textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="button">
                <button type="submit" class="reset-button">修正</button>
            </div>
        </form>
    </div>
@endsection