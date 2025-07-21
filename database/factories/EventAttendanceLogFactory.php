<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventAttendanceLog>
 */
class EventAttendanceLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a random attendance scenario with weighted probabilities
        $scenarios = ['on_time', 'late', 'absent'];
        $weights = [70, 20, 10]; // percentages
        $rand = rand(1, 100);
        
        if ($rand <= 70) {
            $scenario = 'on_time';
        } elseif ($rand <= 90) {
            $scenario = 'late';
        } else {
            $scenario = 'absent';
        }

        // Handle different attendance scenarios
        if ($scenario === 'absent') {
            return [
                'time_in' => null,
                'time_out' => null,
                'attendance_status' => 'absent'
            ];
        }

        // For present/late scenarios, we need to generate realistic times
        // Since event details will be provided when creating, we'll use default event schedule
        $eventTimeIn = Carbon::createFromTime(8, 0); // 8:00 AM
        $eventStartTime = Carbon::createFromTime(8, 30); // 8:30 AM
        $eventEndTime = Carbon::createFromTime(16, 0); // 4:00 PM

        if ($scenario === 'on_time') {
            // Generate timestamps for today with the calculated times
            $today = now()->format('Y-m-d');
            $timeIn = $eventTimeIn->copy()->addMinutes(rand(0, 30));
            $timeOut = $eventEndTime->copy()->subMinutes(rand(0, 30));
            
            return [
                'time_in' => Carbon::parse($today . ' ' . $timeIn->format('H:i:s')),
                'time_out' => Carbon::parse($today . ' ' . $timeOut->format('H:i:s')),
                'attendance_status' => 'present'
            ];
        }

        if ($scenario === 'late') {
            // Generate timestamps for today with the calculated times
            $today = now()->format('Y-m-d');
            $timeIn = $eventStartTime->copy()->addMinutes(rand(1, 60));
            $timeOut = $eventEndTime->copy()->subMinutes(rand(0, 30));

            return [
                'time_in' => Carbon::parse($today . ' ' . $timeIn->format('H:i:s')),
                'time_out' => Carbon::parse($today . ' ' . $timeOut->format('H:i:s')),
                'attendance_status' => 'late'
            ];
        }

        // Fallback
        return [
            'time_in' => null,
            'time_out' => null,
            'attendance_status' => 'absent'
        ];
    }
}
