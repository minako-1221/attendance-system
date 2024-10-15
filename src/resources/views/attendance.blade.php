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
    <div id="attendance-records">
        @include('_records', ['attendanceRecord' => $attendanceRecord, 'users' => $users])
    </div>
    <div class="attendance-pagination">
        {{$users->appends(['date' => $date])->links('vendor.pagination.default')}}
    </div>
</div>

@endsection