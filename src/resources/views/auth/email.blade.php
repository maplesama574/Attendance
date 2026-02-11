@extends('auth.common')

@section('css')
<link rel="stylesheet" href="{{asset('css/email.css')}}">
@endsection

@section('content')

<div class="email">
    <form action="post" action="{{route('verification.verify')}}">
        <div class="email__text">
            <p>登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。</p>
        </div>
        <div class="button">
            <a href="http://localhost:8025/">認証はこちらから</a>
        </div>
        <div class="reset-button">
            <a href="">認証メールを再送する</a>
        </div>
    </form>
</div>

@endsection