<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\BreakRecord;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(10)->create();

        $users->each(function ($user) {
            AttendanceRecord::factory(5)->create(['user_id' => $user->id])
                ->each(function ($attendanceRecord) {
                    BreakRecord::factory(2)->create(['attendance_record_id' => $attendanceRecord->id]);
                });
        });

    }
}
