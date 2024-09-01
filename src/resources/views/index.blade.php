@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}" />
@endsection

@section('content')
<div class="attendance-content">
    <div class="section__title">
        <h2>福場凛太郎さんお疲れ様です！</h2>
    </div>
    <div class="section__grid">
        <button class="button__clock-in">勤務開始</button>
        <button class="button__clock-out">勤務終了</button>
        <button class="button__break-start">休憩開始</button>
        <button class="button__break-end">休憩終了</button>
    </div>
</div>

<script src="{{ asset('js/index.js') }}"></script>

@endsection