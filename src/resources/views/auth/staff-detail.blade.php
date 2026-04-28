@extends('auth.common4')

@section('css')
<link rel="stylesheet" href="css/staff-detail.css">
@endsection

@section('content')
    <div class="attendance">
        <form method="POST" action="{{route('admin.staff-detail')}}">
            @csrf
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
            <div class="button">
                <button class="start-button" type="submit">出勤</button>
            </div>
        </form>
    </div>
@endsection