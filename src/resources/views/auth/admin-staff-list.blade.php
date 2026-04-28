@extends('auth.common4')

@section('css')
<link rel="stylesheet" href="{{asset('css/admin-staff-list.css')}}">
@endsection

@section('content')
    <div class="attendance">
        <div class="title">
            <p class="title-message"> スタッフ一覧</p>
        </div>
        <div class="table">
            <table class="attendance-table">
                <tr class="table-header">
                    <th class="header-item__name">名前</th>
                    <th class="header-item">メールアドレス</th>
                    <th class="header-item__month">月次勤怠</th>
                </tr>
                @foreach($users as $user)
                    <tr class="content">
                        <td class="content-item">{{ $user->name }}</td>
                        <td class="content-item">{{ $user->email}}</td>
                        <td class="content-detail">
                            <a href="{{ route('admin.staff-detail', [
                                'id' => $user->id,
                                'month' => now()->format('Y-m')
                                ]) }}">
                                詳細
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection