@extends('auth.common3')

@section('css')
<link rel="stylesheet" href="{{asset('css/admin-login.css')}}">
@endsection

@section('content')

<div class="login">
    <div class="login__title">
        <h1>管理者ログイン</h1>
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="hidden" name="login_type" value="admin">
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
            <button class="login-button" type="submit">管理者ログインする
            </button>
        </div>
    </form>
</div>

@endsection