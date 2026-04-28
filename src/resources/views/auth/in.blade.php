@extends('auth.common2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/in.css') }}">
@endsection

@section('content')
    <div class="attendance">
        <form method="POST" action="{{route('attendance.action')}}">
            @csrf
            <div class="attendance__status">
                <p class="status">出勤中</p>
            </div>
            <div class="attendance-date">
                <div class="date">
                    <p class="date-detail">{{ \Carbon\Carbon::now()->locale('ja')->isoFormat('YYYY年MM月DD日 (ddd)') }}
                    </p>
                </div>
                <div class="time">
                    <p class="time-detail">{{ \Carbon\Carbon::now()->format("H:i") }}</p>
                </div>
            </div>
            <div class="button">
                <button class="finish-button" type="submit" name="action" value="finish">退勤</button>
                <button class="break-button" type="submit" name="action" value="break">休憩入</button>
            </div>
        </form>
    </div>
@endsection