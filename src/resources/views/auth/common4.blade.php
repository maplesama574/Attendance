<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/app3.css') }}">
    @yield('css')
</head>
<body>
    <header>
        <div class="header">
            <div class="header__logo">
                <a class="header-logo" href="{{route('attendance')}}">
                    <img src="{{ asset('image/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECHヘッダーロゴ">
                </a>
            </div>
            <div class="nav">
                <a class="nav-item" href="{{route('admin.list')}}">勤怠一覧</a>
                <a class="nav-item" href="{{route('admin.staff')}}">スタッフ一覧</a>
                <a class="nav-item" href="{{route('stamp-correction-request-list')}}">申請一覧</a>
                <form method="POST" action="{{route('logout')}}">
                    @csrf
                    <button type="submit" class="nav-item__logout">ログアウト</button>
                </form>
            </div>
        </div>
    </header>
    @yield('content')
</body>
</html>