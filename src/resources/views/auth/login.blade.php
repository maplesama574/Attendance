@extends('auth.common')

@section('css')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection

@section('content')

<div class="login">
    <div class="login__title">
        <h1>ログイン</h1>
    </div>
    <form method="POST" action="{{route('auth.login')}}">
        @csrf
        <div class="login__list">
            <div class="login__item">
                <p class="login__name">メールアドレス</p>
                <input type="email" name="email" value="{{old('email')}}">
            </div>   
            @error('email')
                <div class="error">{{$message}}</div>
            @enderror     
            <div class="login__item">
                <p class="login__name">パスワード</p>
                <input type="password" name="password">
            </div>
            @error('password')
                <div class="error">{{$message}}</div>
            @enderror  
        </div>
        <div class="button">
            <button class="login-button">ログインする
            </button>
            <a class="register" href="{{route('auth.register')}}">会員登録はこちら
            </a>
        </div>
    </form>
</div>

@endsection