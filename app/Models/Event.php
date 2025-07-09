<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\EventStatus;
use App\Enums\Tags;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [

        'title',
        'description',
        'date',
        'location',
        'start_time',
        'end_time',
        'school_year',
        'image',
        'status',
        'tag',

    ];

    protected $casts = [
        'status' => EventStatus::class,
        'tag' => Tags::class, 
    ];

    public function attendanceLogs()
    {
        return $this->hasMany(EventAttendanceLog::class);
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_attendance_logs')
            ->withPivot('time_in', 'time_out', 'attendance_status');
    }

    // Search function
    public function scopeSearch($query, $value)
    {
        $query->where('title', 'like', "%{$value}%")
            ->orWhere('location', 'like', "%{$value}%");
    }
}
