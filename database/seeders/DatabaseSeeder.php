<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Setting;
use App\Models\EventAttendanceLog;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SuperAdminSeeder::class,
            AdminSeeder::class,
            // TsuushinSeeder::class,
            // CLIP
            SchoolYearSeeder::class,
        ]);

        // CLIP
        User::factory(20)->create();

        // CLIP
        // Create events for each school year - variable 1-5 events per month
        $schoolYearMonths = [
            '2022-2023' => [
                ['year' => 2022, 'months' => [7, 8, 9, 10, 11, 12]], // All months 2022
                ['year' => 2023, 'months' => [1, 2, 3, 4, 5, 6]], // All months 2023
            ],
            '2023-2024' => [
                ['year' => 2023, 'months' => [7, 8, 9, 10, 11, 12]], // All months 2023
                ['year' => 2024, 'months' => [1, 2, 3, 4, 5, 6]], // All months 2024
            ],
            '2024-2025' => [
                ['year' => 2024, 'months' => [7, 8, 9, 10, 11, 12]], // All months 2024
                ['year' => 2025, 'months' => [1, 2, 3, 4, 5, 6]], // All months 2025
            ],
            '2025-2026' => [
                ['year' => 2025, 'months' => [7, 8, 9, 10, 11, 12]], // All months 2025
                ['year' => 2026, 'months' => [1, 2, 3, 4, 5, 6]], // All months 2026
            ],
        ];

        // CLIP
        foreach ($schoolYearMonths as $schoolYear => $yearData) {
            foreach ($yearData as $data) {
                foreach ($data['months'] as $month) {
                    // Create 1-5 events for each month (minimum 1, maximum 5)
                    $eventCount = rand(1, 5);
                    Event::factory($eventCount)->forMonth($schoolYear, $data['year'], $month)->create();
                }
            }
        }

        // CLIP
        // Get all events and users
        $events = Event::all();
        $users = User::all();
        
        // CLIP
        // Create diverse attendance patterns for users
        $this->createRealisticAttendancePatterns($events, $users);

        // Set the current school year
        Setting::updateOrCreate(
            ['key' => 'current_school_year'],
            ['value' => '2025-2026'],
        );

        // Set the super admin key
        $existing = Setting::where('key', 's_a_k')->first();

        if (!$existing) {
            Setting::updateOrCreate(
                ['key' => 's_a_k'],
                ['value' =>Hash::make('1234')] // Key
            );
        }
    }

    /**
     * Create realistic attendance patterns for users across events
     */
    private function createRealisticAttendancePatterns($events, $users)
    {
        // Define different user attendance archetypes
        $archetypes = [
            'excellent' => [
                'description' => 'Always present, occasionally late',
                'present_rate' => 0.85,
                'late_rate' => 0.10,
                'absent_rate' => 0.05
            ],
            'good' => [
                'description' => 'Usually present, sometimes late or absent',
                'present_rate' => 0.70,
                'late_rate' => 0.20,
                'absent_rate' => 0.10
            ],
            'average' => [
                'description' => 'Mixed attendance',
                'present_rate' => 0.55,
                'late_rate' => 0.25,
                'absent_rate' => 0.20
            ],
            'poor' => [
                'description' => 'Often absent or late',
                'present_rate' => 0.30,
                'late_rate' => 0.25,
                'absent_rate' => 0.45
            ],
            'chronic_absentee' => [
                'description' => 'Rarely attends events',
                'present_rate' => 0.15,
                'late_rate' => 0.10,
                'absent_rate' => 0.75
            ]
        ];

        // Distribute users across archetypes with realistic proportions
        $archetypeDistribution = [
            'excellent' => 0.20,      // 20% excellent attendance
            'good' => 0.30,           // 30% good attendance
            'average' => 0.25,        // 25% average attendance
            'poor' => 0.20,           // 20% poor attendance
            'chronic_absentee' => 0.05 // 5% chronic absentees
        ];

        // Assign archetypes to users
        $userArchetypes = [];
        $shuffledUsers = $users->shuffle();
        $currentIndex = 0;

        foreach ($archetypeDistribution as $archetype => $proportion) {
            $count = (int) ceil($users->count() * $proportion);
            for ($i = 0; $i < $count && $currentIndex < $users->count(); $i++) {
                $userArchetypes[$shuffledUsers[$currentIndex]->id] = $archetype;
                $currentIndex++;
            }
        }

        // Assign remaining users to 'average' if any
        for ($i = $currentIndex; $i < $users->count(); $i++) {
            $userArchetypes[$shuffledUsers[$i]->id] = 'average';
        }

        // Create attendance logs based on archetypes
        foreach ($events as $event) {
            foreach ($users as $user) {
                $archetype = $userArchetypes[$user->id];
                $rates = $archetypes[$archetype];
                
                // First determine if user is registered/expected for this event
                // Higher attendance archetypes are more likely to be registered
                $registrationProbability = $this->getRegistrationProbability($archetype);
                $isRegistered = (rand(1, 100) / 100) <= $registrationProbability;
                
                if (!$isRegistered) {
                    // User is not registered for this event - no log at all
                    continue;
                }
                
                // User is registered, now determine their attendance status
                $rand = rand(1, 100) / 100;
                
                if ($rand <= $rates['present_rate']) {
                    $status = 'present';
                } elseif ($rand <= $rates['present_rate'] + $rates['late_rate']) {
                    $status = 'late';
                } else {
                    $status = 'absent';
                }

                // Create attendance log for registered users (including absent ones)
                EventAttendanceLog::factory()->create([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                    'attendance_status' => $status
                ]);
            }
        }
    }

    /**
     * Get registration probability based on user archetype
     * Better attendees are more likely to register for events
     */
    private function getRegistrationProbability($archetype): float
    {
        return match($archetype) {
            'excellent' => 0.95,        // Almost always registers
            'good' => 0.85,             // Usually registers
            'average' => 0.70,          // Often registers
            'poor' => 0.55,             // Sometimes registers
            'chronic_absentee' => 0.40, // Rarely registers
            default => 0.70
        };
    }
}
