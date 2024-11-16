@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/verify-email.css')}}">
@endsection

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h1>2段階認証</h1>
    <p>ご登録のメールアドレスに確認リンクを送信しました。<br>リンクをクリックして認証を完了してください。</p>
</div>
@endsection
