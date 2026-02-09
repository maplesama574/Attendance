<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="css/app.css">
    @yield('css')
</head>
<body>
    <header>
        <div class="header">
            <a class="header-logo" href="{{route('auth.login')}}">
                <img src="image/COACHTECHヘッダーロゴ.png" alt="COACHTECHヘッダーロゴ">
            </a>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>