<div class="attendance-table">
    <table class="attendance-table__inner">
        <tr class="attendance-table__row">
            <th class="attendance-table__header">名前</th>
            <th class="attendance-table__header">勤務開始</th>
            <th class="attendance-table__header">勤務終了</th>
            <th class="attendance-table__header">休憩時間</th>
            <th class="attendance-table__header">勤務時間</th>
        </tr>
        @foreach($users as $user)
                <tr class="attendance-table__row">
                    <td class="attendance-table__item">
                        {{$user->name}}
                    </td>
                    <td class="attendance-table__item">
                        @if($user->attendanceRecords->where('clock_in', '>=', \Carbon\Carbon::parse($date)->startOfDay())->where('clock_in', '<=', \Carbon\Carbon::parse($date)->endOfDay())->isNotEmpty())

                            {{ \Carbon\Carbon::parse($user->attendanceRecords->where('clock_in', '>=', \Carbon\Carbon::parse($date)->startOfDay())->where('clock_in', '<=', \Carbon\Carbon::parse($date)->endOfDay())->first()->clock_in)->format('H:i:s') }}
                        @else
                            00:00:00
                        @endif
                    </td>
                    <td class="attendance-table__item">
                        @if($user->attendanceRecords->isNotEmpty())
                            {{\Carbon\Carbon::parse($user->attendanceRecords->first()->clock_out)->format('H:i:s')}}
                        @else
                            00:00:00
                        @endif
                    </td>
                    <td class="attendance-table__item">
                        @if($user->attendanceRecords->isNotEmpty())
                            {{gmdate('H:i:s', $user->attendanceRecords->first()->breakRecords->sum('break_total'))}}
                        @else
                            00:00:00
                        @endif
                    </td>
                    <td class="attendance-table__item">
                        @if($user->attendanceRecords->isNotEmpty())
                            {{gmdate('H:i:s', $user->attendanceRecords->first()->effective_work_hours)}}
                        @else
                            00:00:00
                        @endif
                    </td>
                </tr>
        @endforeach
    </table>
</div>
<div class="attendance-pagination">
    {{$users->links('vendor.pagination.default')}}
</div>