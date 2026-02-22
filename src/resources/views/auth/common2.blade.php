<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="css/app2.css">
    @yield('css')
</head>
<body>
    <header>
        <div class="header">
            <div class="header__logo">
                <a class="header-logo" href="{{route('attendance')}}">
                    <img src="image/COACHTECHヘッダーロゴ.png" alt="COACHTECHヘッダーロゴ">
                </a>
            </div>
            <div class="nav">
                <a class="nav-item" href="{{route('attendance')}}">勤怠</a>
                <a class="nav-item" href="{{route('attendance-list')}}">勤怠一覧</a>
                <a class="nav-item" href="{{route('stamp-correction-request-list')}}">申請</a>
                <form method="POST" action="asset{{route('login')}}">
                    @csrf
                    <a class="nav-item" href="{{route('login')}}">ログアウト</a>
                </form>
            </div>
        </div>
    </header>
    @yield('content')
</body>
</html>