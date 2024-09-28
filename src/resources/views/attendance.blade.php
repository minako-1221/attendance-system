@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('js')
<script src="{{ asset('js/attendance.js') }}" defer></script>
@endsection

@section('content')
<div class="attendance__content">
    <div class="date-navigation">
        <button id="prev-date" class="date-nav__button">&lt;</button>
        <span id="current-date" data-date="{{ $date }}">{{ $date }}</span>
        <button id="next-date" class="date-nav__button">&gt;</button>
    </div>
    @include('_records', ['attendanceRecords' => $attendanceRecords,'users'=>$users])
</div>

@endsection