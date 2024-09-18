<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AttendanceRecord extends Model
{
    use HasFactory;
    protected $table = 'attendance_records';

    protected $fillable = [
        'user_id',
        'clock_in',
        'clock_out',
        'clock_total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breakRecords()
    {
        return $this->hasMany(BreakRecord::class);
    }

    public function getEffectiveWorkHoursAttribute()
    {
        if(!$this->clock_in || !$this->clock_out){
            return 0;
        }

        $clockIn = Carbon::parse($this->clock_in);
        $clockOut = Carbon::parse($this->clock_out);
        $breakTotal = $this->breakRecords->sum('break_total');

        $workHours = $clockOut->diffInMinutes($clockIn) - $breakTotal;

        return $workHours;
    }
}
