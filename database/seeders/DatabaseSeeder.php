<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Setting;
use App\Models\EventAttendanceLog;

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
        // $this->call([
        //     SuperAdminSeeder::class,
        //     AdminSeeder::class,
        //     TsuushinSeeder::class,
        //     SchoolYearSeeder::class,
        // ]);

        User::factory(9)->create();
    
        // Event::factory(30)->create();

        // Setting::create([
        //     'key' => 'current_school_year',
        //     'value' => '2024-2025',
        // ]);

        // Create events for each school year - 5 events per month for all 12 months of each year
        // $schoolYearMonths = [
        //     '2022-2023' => [
        //         ['year' => 2022, 'months' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]], // All months 2022
        //         ['year' => 2023, 'months' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]], // All months 2023
        //     ],
        //     '2023-2024' => [
        //         ['year' => 2023, 'months' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]], // All months 2023
        //         ['year' => 2024, 'months' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]], // All months 2024
        //     ],
        //     '2024-2025' => [
        //         ['year' => 2024, 'months' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]], // All months 2024
        //         ['year' => 2025, 'months' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]], // All months 2025
        //     ],
        //     '2025-2026' => [
        //         ['year' => 2025, 'months' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]], // All months 2025
        //         ['year' => 2026, 'months' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]], // All months 2026
        //     ],
        // ];

        // foreach ($schoolYearMonths as $schoolYear => $yearData) {
        //     foreach ($yearData as $data) {
        //         foreach ($data['months'] as $month) {
        //             // Create 5 events for each month
        //             Event::factory(5)->forMonth($schoolYear, $data['year'], $month)->create();
        //         }
        //     }
        // }

        // // Get all events and users
        // $events = Event::all();
        // $users = User::all();

        // // Create attendance logs for each event
        // foreach ($events as $event) {
        //     // For each event, create attendance logs for 70% of users
        //     $attendingUsers = $users->random((int) ceil($users->count() * 0.7));
            
        //     foreach ($attendingUsers as $user) {
        //         EventAttendanceLog::factory()->create([
        //             'event_id' => $event->id,
        //             'user_id' => $user->id,
        //         ]);
        //     }
        // }

        // // Set the current school year
        // Setting::updateOrCreate(
        //     ['key' => 'current_school_year'],
        //     ['value' => '2024-2025']
        // );
    }
}
