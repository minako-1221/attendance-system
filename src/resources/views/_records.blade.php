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
                        @php
                            $attendanceRecord = $user->attendanceRecords
                                ->where('clock_in', '>=', \Carbon\Carbon::parse($date)->startOfDay())
                                ->where('clock_in', '<=', \Carbon\Carbon::parse($date)->endOfDay())
                                ->first();

                            $breakRecords = $attendanceRecord
                                ? $attendanceRecord->breakRecords
                                    ->where('created_at', '>=', \Carbon\Carbon::parse($date)->startOfDay())
                                    ->where('created_at', '<=', \Carbon\Carbon::parse($date)->endOfDay())
                                : collect();

                                $totalBreakTime = $breakRecords->sum('break_total');
                        @endphp
                        <tr class="attendance-table__row">
                            <td class="attendance-table__item">
                                {{$user->name}}
                            </td>
                            <td class="attendance-table__item">
                                @if($attendanceRecord)
                                    {{ \Carbon\Carbon::parse($attendanceRecord->clock_in)->format('H:i:s') }}
                                @else
                                    00:00:00
                                @endif
                            </td>
                            <td class="attendance-table__item">
                                @if($attendanceRecord && $attendanceRecord->clock_out)
                                    {{ \Carbon\Carbon::parse($attendanceRecord->clock_out)->format('H:i:s') }}
                                @else
                                    00:00:00
                                @endif
                            </td>
                            <td class="attendance-table__item">
                                @if($totalBreakTime)
                                    {{ gmdate('H:i:s', $totalBreakTime) }}
                                @else
                                    00:00:00
                                @endif
                            </td>
                            <td class="attendance-table__item">
                                @if($attendanceRecord && $attendanceRecord->clock_out)
                                    {{ gmdate('H:i:s', $attendanceRecord->clock_total - $totalBreakTime) }}
                                @else
                                    00:00:00
                                @endif
                            </td>
                        </tr>
        @endforeach
    </table>
</div>
