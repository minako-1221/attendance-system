<?php

namespace Database\Factories;

use App\Models\AttendanceRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AttendanceRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = AttendanceRecord::class;
    public function definition()
    {
        $clockIn = Carbon::now()->subDays(rand(1, 30))->subHours(rand(1, 8));
        $clockOut = (clone $clockIn)->addHours(rand(4, 8));

        $user = User::inRandomOrder()->first();
        if(!$user){
            $user = User::factory()->create();
        }

        return [
            'user_id' => $user->id,
            'clock_in' => $clockIn,
            'clock_out' => $clockOut,
            'clock_total' => $clockOut->diffInSeconds($clockIn),
        ];
    }
}
