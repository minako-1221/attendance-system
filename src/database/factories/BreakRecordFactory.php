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
        $breakStart = Carbon::now()->subDays(rand(1, 30))->addHours(rand(1, 8));
        $breakEnd = (clone $breakStart)->addMinutes(rand(15, 60));

        return [
            'attendance_record_id'=>AttendanceRecord::inRandomOrder()->first()->id,
            'break_start'=>$breakStart,
            'break_end'=>$breakEnd,
            'break_total'=>$breakEnd->diffInMinutes($breakStart),
        ];
    }
}
