@extends('auth.common4')

@section('css')
<link rel="stylesheet" href="{{asset('css/stamp-correction-request-list.css')}}">
@endsection

@section('content')
    <div class="attendance">
        <div class="title">
            <p class="title-message"> 申請一覧</p>
        </div>
        <div class="approval">
            <a class="{{ $status == 0 ? 'active' : '' }}" href="{{ route('stamp-correction-request-list', ['status' => 0]) }}">
                承認待ち
            </a>
            <a class="{{ $status == 1 ? 'active' : '' }}" href="{{ route('stamp-correction-request-list', ['status' => 1]) }}">
                承認済み
            </a>
        </div>
        <div class="border"></div>
        <div class="table">
            <table class="approval-table">
                <tr class="table-header">
                    <th class="header-item">状態</th>
                    <th class="header-item">名前</th>
                    <th class="header-item">対象日時</th>
                    <th class="header-item">申請理由</th>
                    <th class="header-item">申請日時</th>
                    <th class="header-item">詳細</th>
                </tr>
                @foreach($attendances as $attendance)
                    <tr class="content">
                        <td class="content-item">
                            {{ $attendance->status == 0 ? '承認待ち' : '承認済み' }}
                        </td>
                        <td class="content-item">{{ $attendance->user->name }}</td>
                        <td class="content-item">{{ \Carbon\Carbon::parse($attendance->start_datetime)->isoFormat('YYYY/MM/DD') }}</td>
                        <td class="content-item">
                            {{ $attendance->remarks }}
                        </td>
                        <td class="content-item">
                            {{ \Carbon\Carbon::parse($attendance->approval_datetime)->isoFormat('YYYY/MM/DD') }}
                        </td>
                        <td class="content-detail">
                            <a href="{{ route('admin.approval-detail', ['attendance_correct_request_id' => $attendance->id]) }}">
                                詳細
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection