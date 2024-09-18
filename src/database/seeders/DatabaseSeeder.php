<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        AttendanceRecord::factory(100)->create()->each(function ($attendanceRecord) {
            BreakRecord::factory(rand(1, 3))->create([
                'attendance_record_id' => $attendanceRecord->id,
            ]);
        });

        $this->call(UserSeeder::class);
    }
}
