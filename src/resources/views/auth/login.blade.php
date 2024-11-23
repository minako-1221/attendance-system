@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection

@section('content')
<div class="login__content">
    <div class="login-form__heading">
        <h2>ログイン</h2>
    </div>
    <form class="form__login" action="/login" method="post">
        @csrf
        <div class="form__content">
            <div class="form__input">
                <input type="text" name="email" value="{{old('email')}}" placeholder="メールアドレス" />
            </div>
            <div class="form__error">
                @error('email')
                    {{$message}}
                @enderror
            </div>
        </div>
        <div class="form__content">
            <div class="form__input">
                <input type="password" name="password" placeholder="パスワード" />
            </div>
            <div class="form__error">
                @error('password')
                    {{$message}}
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">ログイン</button>
        </div>
    </form>
    <div class="register__link">
        <div class="register__item">
            <span class="register__item-text">アカウントをお持ちでない方はこちらから</span>
        </div>
        <div class="register__item">
            <a href="/register" class="register__item-button">会員登録</a>
        </div>
    </div>
</div>
@endsection