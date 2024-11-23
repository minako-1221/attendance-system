@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('js')
<script id="button-states" type="application/json">
    @json($buttonStates)
</script>
<script src="{{ asset('js/index.js') }}" defer></script>
@endsection


@section('content')
<div class="attendance-content">
    <div class="section__title">
        @if($user)
            <h2>{{ $user->name }}さんお疲れ様です！</h2>
        @endif
    </div>
    <div class="section__grid">
        <form action="{{ route('clock.in') }}" method="POST">
            @csrf
            <button class="button__clock-in" @if(!$buttonStates->clock_in) disabled @endif>
                勤務開始
            </button>
        </form>
        <form action="{{ route('clock.out') }}" method="POST">
            @csrf
            <button class="button__clock-out" @if(!$buttonStates->clock_out) disabled @endif>
                勤務終了
            </button>
        </form>
        <form action="{{ route('break.start') }}" method="POST">
            @csrf
            <button class="button__break-start" @if(!$buttonStates->break_start) disabled @endif>
                休憩開始
            </button>
        </form>
        <form action="{{ route('break.end') }}" method="POST">
            @csrf
            <button class="button__break-end" @if(!$buttonStates->break_end) disabled @endif>
                休憩終了
            </button>
        </form>
    </div>
</div>


@endsection