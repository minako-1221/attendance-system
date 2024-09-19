@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endsection

@section('js')
<script src="{{ asset('js/attendance.js') }}" defer></script>
@endsection

@section('content')
<div class="attendance__content">
    <div class="date-navigation">
        <button id="prev-date" class="date-nav__button">&lt;</button>
        <span id="current-date" data-date="{{$date}}">{{$date}}</span>
        <button id="next-date" class="date-nav__button">&gt;</button>
    </div>
    <div class="attendance-table">
        <table class="attendance-table__inner">
            <tr class="attendance-table__row">
                <th class="attendance-table__header">名前</th>
                <th class="attendance-table__header">勤務開始</th>
                <th class="attendance-table__header">勤務終了</th>
                <th class="attendance-table__header">休憩時間</th>
                <th class="attendance-table__header">勤務時間</th>
            </tr>
            @foreach($attendanceRecords as $record)
                <tr class="attendance-table__row">
                    <td class="attendance-table__item">
                        {{$record->user->name}}
                    </td>
                    <td class="attendance-table__item">
                        {{\Carbon\Carbon::parse($record->clock_in)->format('H:i:s')}}
                    </td>
                    <td class="attendance-table__item">
                        {{\Carbon\Carbon::parse($record->clock_out)->format('H:i:s')}}
                    </td>
                    <td class="attendance-table__item">
                        {{gmdate('H:i:s', $record->breakRecords->sum('break_total'))}}
                    </td>
                    <td class="attendance-table__item">
                        {{gmdate('H:i:s', $record->effective_work_hours)}}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="attendance-pagination">
        {{$attendanceRecords->links('vendor.pagination.default')}}
    </div>
</div>
@endsection