<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\EventStatus;
use App\Enums\AttendanceStatus;
use App\Enums\TsuushinRequest;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [

        'title',
        'date',
        'location',
        'time_in',
        'start_time',
        'end_time',
        'school_year',
        'image',
        'status',
        'tsuushin_request',

    ];

    protected $casts = [
        
        'status' => EventStatus::class,
        'tsuushin_request' => TsuushinRequest::class,

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

    // // Search function
    // public function scopeSearch($query, $value)
    // {
    //     $query->where('title', 'like', "%{$value}%")
    //         ->orWhere('date', 'like', "%{$value}%")
    //         ->orWhere('location', 'like', "%{$value}%");
    // }

    // Search function
    public function scopeSearch($query, $value)
    {
        $search = strtolower(trim($value));

        $statusMatch = collect(AttendanceStatus::cases())
            ->first(function ($case) use ($search) {
                return strtolower($case->name) === $search 
                    || strtolower($case->label()) === $search;
            });

        $query->where(function ($q) use ($search, $statusMatch) {
            $q->where('title', 'like', "%{$search}%")
            ->orWhere('date', 'like', "%{$search}%")
            ->orWhere('location', 'like', "%{$search}%");

            if ($statusMatch) {
                $q->orWhereHas('attendanceLogs', function ($logQuery) use ($statusMatch) {
                    $logQuery->where('user_id', Auth::id()) // filter to current user
                            ->where('attendance_status', $statusMatch->value); // match backing value
                });
            }
        });
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

    // Obtain event initials
    public function getInitialsAttribute()
    {
        // Remove extra spaces and split the title into words
        $words = preg_split("/\s+/", trim($this->title));
        $initials = '';

        foreach ($words as $word) {
            if (isset($word[0])) {
                $initials .= mb_strtoupper($word[0]);
            }
        }

        
        return $initials;
    }

    // Random color for event avatar
    public function getAvatarColorAttribute()
    {
        $colors = [
                'zinc', 'red', 'orange', 'amber', 'yellow',
                'lime', 'green', 'emerald', 'teal', 'cyan',
                'sky', 'blue', 'indigo', 'violet', 'purple',
                'fuchsia', 'pink', 'rose'];

        // Use a hash of the event title (or ID) to pick a color deterministically
        $hash = crc32($this->title ?? $this->id);
        $index = $hash % count($colors);

        return $colors[$index];
    }
}
