@extends('auth.common2')

@section('css')
<link rel="stylesheet" href="css/attendance.css">
@endsection

@section('content')
    <div class="attendance">
        <form method="POST" action="{{route('attendance')}}">
            @csrf
            <div class="attendace__condition">
                
            </div>
            <div class="attendance-date">
                <div class="date">
                    <p class="date-detail">{{ \Carbon\Carbon::now()->format("Y/m/d") }}
                    </p>
                </div>
                <div class="time">
                    <p class="time-detail">{{ \Carbon\Carbon::now()->format("H:i") }}</p>
                </div>
            </div>
            <div class="button">
                <button class="start-button">出勤</button>
            </div>
        </form>
    </div>
@endsection