<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserApproval;
use App\Enums\UserRole;
use App\Enums\AccountStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [

        'name',
        'email',
        'password',
        'year_level',
        'course',
        'role',
        'status',
        'account_status'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'status' => UserApproval::class,
            'account_status' => AccountStatus::class
        ];
    }

    /**
     * Get the user's initials  
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // For user routing (Route model binding)
    // public function getRouteKeyName(): string
    // {
    //     return 'name';
    // }

    // Search function
    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%")
            ->orWhere('year_level', 'like', "%{$value}%")
            ->orWhere('course', 'like', "%{$value}%");
    }

    // pivot table relationship
    public function attendedEvents()
    {
        return $this->belongsToMany(Event::class, 'event_attendance_logs')
            ->withPivot('time_in', 'time_out', 'attendance_status');
    }

    public function attendanceLogs()
    {
        return $this->hasMany(EventAttendanceLog::class);
    }
}
