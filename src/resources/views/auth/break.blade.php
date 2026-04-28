@extends('auth.common2')

@section('css')
<link rel="stylesheet" href="{{asset('css/break.css')}}">
@endsection

@section('content')
    <div class="attendance">
        <form method="POST" action="{{route('attendance.break.end')}}">
            @csrf
            <div class="attendance__status">
                <p class="status">休憩中</p>
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
                <button class="attendance-button" type="submit">休憩戻</button>
            </div>
        </form>
    </div>
@endsection