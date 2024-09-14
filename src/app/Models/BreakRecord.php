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

    public function attendanceRecord()
    {
        return $this->belongsTo(AttendanceRecord::class);
    }

    public function getBreakTotalAttribute()
    {
        if($this->break_start && $this->break_end){
            $breakStart = Carbon::parse($this->break_start);
            $breakEnd = Carbon::parse($this->break_end);
            return $breakEnd->diffInSeconds($breakStart);
        }
        return 0;
    }

    public function setBreakEndAttribute($value)
    {
        $this->attributes['break_end'] = $value;

        if($this->break_start){
            $breakStart = Carbon::parse($this->break_start);
            $breakEnd = Carbon::parse($value);
            $this->attributes['break_total'] = $breakEnd->diffInSeconds($breakStart);
        }
    }
}

