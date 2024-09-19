@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}" />
@endsection

@section('js')
<script src="{{ asset('js/index.js') }}" defer></script>
@endsection

@section('content')
<div class="attendance-content">
    <div class="section__title">
        @if($user)
            <h2>{{$user->name}}さんお疲れ様です！</h2>
        @endif
    </div>
    <div class="section__grid">
            <form action="{{ route('clock.in') }}" method="POST">
                @csrf
                <button class="button__clock-in">勤務開始</button>
            </form>
            <form action="{{ route('clock.out') }}" method="POST">
                @csrf
                <button class="button__clock-out">勤務終了</button>
            </form>
            <form action="{{ route('break.start') }}" method="POST">
                @csrf
                <button class="button__break-start">休憩開始</button>
            </form>
            <form action="{{ route('break.end') }}" method="POST">
                @csrf
                <button class="button__break-end">休憩終了</button>
            </form>
    </div>
</div>


@endsection