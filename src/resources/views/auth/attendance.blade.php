@extends('auth.common2')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endsection

@section('content')
    <div class="attendance">
        <form action="POST" action="{{route('auth.attendance__start')}}">
            @csrf
            <div class="attendace__condition">
                <p class="attendance-time">
                    {{$isStarted ? '出勤中' : '勤務外'}}
                </p>
            </div>
            <div class="attendance-date">
                <div class="date">
                    <input type="date" name="start_date" id="start_date">
                </div>
                <div class="time">
                    <input type="time" name="start_time" id="start_time">
                </div>
            </div>
            <div class="button">
                <button class="start-button">出勤</button>
            </div>
        </form>
    </div>
@endsection