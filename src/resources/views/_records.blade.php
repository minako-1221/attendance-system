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