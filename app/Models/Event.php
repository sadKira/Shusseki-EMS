<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [

        'title',
        'description',
        'start_time',
        'end_time',
        'school_year',

    ];
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function attendanceLogs()
    {
        return $this->hasMany(EventAttendanceLog::class);
    }  

    public function attendees() 
    {
        return $this->belongsToMany(User::class, 'event_attendance_logs')
                        ->withPivot('time_in', 'time_out', 'attendance_status');
    }
}
