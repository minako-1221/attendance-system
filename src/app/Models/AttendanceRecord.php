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

    protected $casts = [
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breakRecords()
    {
        return $this->hasMany(BreakRecord::class);
    }

    public function setClockOutAttribute($value)
    {
        $this->attributes['clock_out'] = $value;

        if ($this->clock_in) {
            $clockIn = $this->clock_in;
            $clockOut = $value;
            $this->attributes['clock_total'] = $clockOut->diffInSeconds($clockIn);
            $this->save();
        }
    }

    public function getEffectiveWorkHoursAttribute()
    {
        if (!$this->clock_in || !$this->clock_out) {
            return 0;
        }

        $clockIn = $this->clock_in;
        $clockOut = $this->clock_out;
        $totalBreakSeconds = $this->breakRecords->sum('break_total');


        $workSeconds = $clockOut->diffInSeconds($clockIn) - $totalBreakSeconds;

        return $workSeconds;
    }
}
