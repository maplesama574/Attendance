@extends('auth.common2')

@section('css')
<link rel="stylesheet" href="{{asset('css/out.css')}}">
@endsection

@section('content')
    <div class="attendance">
        <div class="attendance__status">
            <p class="status">勤務外</p>
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
        <div class="finish">
            <p class="message">お疲れさまでした。</p>
        </div>
    </div>
@endsection