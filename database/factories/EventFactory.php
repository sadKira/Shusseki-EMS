<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    private static $eventNameCounter = 1;
    private static $baseEventNames = [
        'Intramurals',
        'Nyuugakushiki',
        'Mental Health Awareness Seminar',
        'Family Day',
        'Phil-Jap Festival',
        'MKD General Assembly',
        'Sports Festival',
        'Cultural Exchange Day',
        'Career Guidance Seminar',
        'Science Fair',
        'Arts Exhibition',
        'Music Festival',
        'Leadership Summit',
        'Academic Olympics',
        'Environmental Awareness Day'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Use random school year as default
        $schoolYear = fake()->randomElement([
            '2022-2023',
            '2023-2024', 
            '2024-2025',
            '2025-2026'
        ]);
        
        $baseName = fake()->randomElement(self::$baseEventNames);
        $uniqueName = $baseName . ' ' . self::$eventNameCounter++;

        return [
            'title' => $uniqueName,
            'date' => $this->generateDateForSchoolYear($schoolYear),
            'location' => fake()->randomElement([
                'MKD AVR',
                'MKD Sky Hall',
                'PNJK-IS Gymnasium',
                'PNJK-IS Sports Complex',
                'MKD Library',
                'MKD Conference Room',
                'School Grounds',
                'Auditorium'
            ]),
            'time_in' => Carbon::createFromTime(rand(8, 11), [0, 30][rand(0, 1)])
                ->format('H:i:s'),
            'start_time' => Carbon::createFromTime(rand(8, 11), [0, 30][rand(0, 1)])
                ->format('H:i:s'),
            'end_time' => Carbon::createFromTime(rand(13, 17), [0, 30][rand(0, 1)])
                ->format('H:i:s'),
            'school_year' => $schoolYear,
            'image' => fake()->randomElement([
                'https://shusseki-ems.site/storage/events/intrams.jfif',
                'https://shusseki-ems.site/storage/events/clubfair.jfif',
                'https://shusseki-ems.site/storage/events/galanight.jfif',
                'https://shusseki-ems.site/storage/events/nyuugakushiki.jfif',
                'https://shusseki-ems.site/storage/events/personnelsday.jfif',
                'https://shusseki-ems.site/storage/events/pjfest.jfif',
            ]),
            'status' => fake()->randomElement([
                'not_finished',
                'finished',
                'postponed',
            ]),
            'tsuushin_request' => 'not_approved',
        ];
    }

    /**
     * Generate a date that falls within the appropriate years for a school year.
     * For example, 2023-2024 school year should only have dates in 2023 or 2024.
     */
    private function generateDateForSchoolYear(string $schoolYear): string
    {
        // Extract years from school year string
        $years = explode('-', $schoolYear);
        $firstYear = (int) $years[0];
        $secondYear = (int) $years[1];
        
        // Define typical academic year periods
        $periods = [
            // First semester: July-December of first year
            ['start' => $firstYear . '-07-15', 'end' => $firstYear . '-12-31'],
            // Second semester: January-March of second year  
            ['start' => $secondYear . '-01-01', 'end' => $secondYear . '-03-30'],
        ];
        
        // Randomly choose a period
        $period = fake()->randomElement($periods);
        
        return fake()->dateTimeBetween($period['start'], $period['end'])->format('Y-m-d');
    }

    /**
     * Generate a date within a specific month and year.
     */
    private function generateDateForMonth(int $year, int $month): string
    {
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate)); // Last day of the month
        
        return fake()->dateTimeBetween($startDate, $endDate)->format('Y-m-d');
    }

    /**
     * Configure the factory to generate events for a specific school year.
     */
    public function forSchoolYear(string $schoolYear): static
    {
        return $this->state(function (array $attributes) use ($schoolYear) {
            return [
                'school_year' => $schoolYear,
                'date' => $this->generateDateForSchoolYear($schoolYear),
            ];
        });
    }

    /**
     * Configure the factory to generate events for a specific month and school year.
     */
    public function forMonth(string $schoolYear, int $year, int $month): static
    {
        return $this->state(function (array $attributes) use ($schoolYear, $year, $month) {
            return [
                'school_year' => $schoolYear,
                'date' => $this->generateDateForMonth($year, $month),
            ];
        });
    }
}
