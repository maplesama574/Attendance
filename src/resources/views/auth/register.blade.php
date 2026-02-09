@extends('auth.common')

@section('css')
<link rel="stylesheet" href="{{asset('css/register.css')}}">
@endsection

@section('content')

<div class="register">
    <div class="register__title">
        <h1>会員登録</h1>
    </div>
    <form method="POST" action="{{route('auth.register')}}">
        @csrf
        <div class="register__list">
            <div class="register__item">
                <p class="register__name">名前</p>
                <input type="text" name="name" value="{{old('name')}}">
            </div>
            @error('name')
                <div class="error">{{$message}}</div>
            @enderror
            <div class="register__item">
                <p class="register__name">メールアドレス</p>
                <input type="email" name="email" value="{{old('email')}}">
            </div>   
            @error('email')
                <div class="error">{{$message}}</div>
            @enderror     
            <div class="register__item">
                <p class="register__name">パスワード</p>
                <input type="password" name="password">
            </div>
            @error('password')
                <div class="error">{{$message}}</div>
            @enderror  
            <div class="register__item">
                <p class="register__name">パスワード確認</p>
                <input type="password" name="password_confirmation">
            </div>
        </div>
        <div class="button">
            <button class="register-button">登録する</button>
            <a class="login" href="{{route('auth.login')}}">ログインはこちら
            </a>
        </div>
    </form>
</div>

@endsection