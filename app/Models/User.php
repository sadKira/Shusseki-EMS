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

        'student_id',
        'name',
        'email',
        'password',
        'year_level',
        'course',
        'qrcode',
        'role',
        'status',
        'account_status',

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
            'account_status' => AccountStatus::class,
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
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
    // public function scopeSearch($query, $value)
    // {
    //     $query->where('name', 'like', "%{$value}%")
    //         ->orWhere('email', 'like', "%{$value}%")
    //         ->orWhere('year_level', 'like', "%{$value}%")
    //         ->orWhere('course', 'like', "%{$value}%")
    //         ->orWhere('student_id', 'like', "%{$value}%");
    // }

    public function scopeSearch($query, $value)
    {
        if (!$value) return $query;

        $value = strtolower($value);

        // Mapping of full course names to abbreviations
        $courseMap = [
            'bachelor of arts in international studies' => 'abis',
            'bachelor of science in information systems' => 'bsis',
            'bachelor of human services' => 'bhs',
            'bachelor of secondary education' => 'bsed',
        ];

        return $query->where(function ($q) use ($value, $courseMap) {
            $q->where('name', 'like', "%{$value}%")
                ->orWhere('email', 'like', "%{$value}%")
                ->orWhere('year_level', 'like', "%{$value}%")
                ->orWhere('student_id', 'like', "%{$value}%");

            // Check both full and simplified course names
            $q->orWhere(function ($q2) use ($value, $courseMap) {
                // Search full course name
                $q2->where('course', 'like', "%{$value}%");

                // Search mapped simplified names
                foreach ($courseMap as $full => $abbr) {
                    if (str_contains($abbr, $value)) {
                        $q2->orWhere('course', 'like', "%{$full}%");
                    }
                }
            });
        });
    }


    public function highlightField($field, $term)
    {
        $value = $this->{$field};

        if (!$term || stripos($value, $term) === false) {
            return e($value); // No HTML escaping here
        }

        return preg_replace(
            "/(" . preg_quote($term, '/') . ")/i",
            '<mark class="bg-[var(--color-accent)] text-black">$1</mark>',
            e($value)
        );
    }

    public function highlightText($text, $term)
    {
        if (!$term || stripos($text, $term) === false) {
            return e($text); // Escape if there's no match
        }

        return preg_replace(
            "/" . preg_quote($term, '/') . "/i",
            '<mark class="bg-[var(--color-accent)] text-black">$0</mark>',
            e($text)
        );
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
