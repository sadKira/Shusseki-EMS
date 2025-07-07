<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [

        'title',
        'description',
        'location',
        'start_time',
        'end_time',
        'school_year',
        'image',
        'status',

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



    // Search function
    public function scopeSearch($query, $value)
    {
        $query->where('title', 'like', "%{$value}%")
            ->orWhere('location', 'like', "%{$value}%");

    }
}
