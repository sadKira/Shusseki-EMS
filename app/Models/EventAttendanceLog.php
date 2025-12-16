<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventAttendanceLog extends Model
{
    use HasFactory;
    protected $fillable = [

        'event_id',
        'user_id',
        'time_in',
        'time_out',
        'attendance_status',
    ];

    protected $casts = [
        'attendance_status' => AttendanceStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
