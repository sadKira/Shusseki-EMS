<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\EventStatus;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [

        'title',
        'description',
        'date',
        'location',
        'time_in',
        'start_time',
        'end_time',
        'school_year',
        'image',
        'status',

    ];

    protected $casts = [
        
        'status' => EventStatus::class,

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

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'title';
    }
}
