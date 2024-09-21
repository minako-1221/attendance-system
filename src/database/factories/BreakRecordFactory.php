<?php

namespace Database\Factories;

use App\Models\BreakRecord;
use App\Models\AttendanceRecord;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class BreakRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = BreakRecord::class;
    public function definition()
    {
        $attendance = AttendanceRecord::inRandomOrder()->first();

        $clockIn = Carbon::parse($attendance->clock_in);

        $clockOut = Carbon::parse($attendance->clock_out);

        $breakStart = $clockIn
        ->addSeconds(rand(0,$clockOut->diffInSeconds($clockIn)-3600));

        $breakEnd = (clone $breakStart)->addSeconds(rand(900, 3600));

        return [
            'attendance_record_id'=>$attendance->id,
            'break_start'=>$breakStart,
            'break_end'=>$breakEnd,
            'break_total'=>$breakEnd->diffInSeconds($breakStart),
        ];
    }
}
