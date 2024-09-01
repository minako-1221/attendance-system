@yield('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endsection

@section('content')
<div class="date-navigation">
    <button id="prev-date" class="date-nav__button">&lt;</button>
    <span id="current-date">{{ \Carbon\Carbon::now()->format('Y-m-d') }}</span>
    <button id="next-date" class="date-nav-button">&gt;</button>
</div>
<div class="attendance__content">
    <div class="attendance-table">
        <table class="attendance-table__inner">
            <tr class="attendance-table__row">
                <th class="attendance-table__header">名前</th>
                <th class="attendance-table__header">勤務開始</th>
                <th class="attendance-table__header">勤務終了</th>
                <th class="attendance-table__header">休憩時間</th>
                <th class="attendance-table__header">勤務時間</th>
            </tr>
            <tr class="attendance-table__row">
                <td class="attendance-table__item">
                    
                </td>
            </tr>
        </table>
    </div>
</div>