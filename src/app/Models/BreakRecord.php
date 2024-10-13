<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BreakRecord extends Model
{
    use HasFactory;
    protected $table = 'break_records';

    protected $fillable = [
        'attendance_record_id',
        'break_start',
        'break_end',
        'break_total',
    ];

    protected $casts = [
        'break_start' => 'datetime',
        'break_end' => 'datetime',
    ];

    public function attendanceRecord()
    {
        return $this->belongsTo(AttendanceRecord::class);
    }

    public function setBreakEndAttribute($value)
    {
        $this->attributes['break_end'] = $value;

        if ($this->break_start) {
            $breakStart = $this->break_start;
            $breakEnd = $value;
            $this->attributes['break_total'] = $breakEnd->diffInSeconds($breakStart);
            $this->save();
        }
    }

}
