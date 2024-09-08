<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakRecord extends Model
{
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
}
