<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement([
                'Intramurals',
                'Nyuugakushiki',
                'Mental Health Awareness Seminar',
                'ABIS General Assembly',
                'BSIS General Assembly',
                'BHS General Assembly',
                'BSEd General Assembly',
                'Phil-Jap Festival',
            ]),

            'description' => fake()->paragraph(),
            'date' => fake()->dateTimeBetween('2025-07-01','2025-07-30'),

            'location' => fake()->randomElement([
                'MKD AVR',
                'MKD Sky Hall',
                'PNJK-IS Gymnasium',
                'PNJK-IS Sports Complex',
            ]),

            // 'start_time' =>  Carbon::createFromTime(rand(8, 11), [0, 30][rand(0, 1)])
            // ->format('H:i:s'),
            // 'end_time' => Carbon::createFromTime(rand(13, 17), [0, 30][rand(0, 1)])
            // ->format('H:i:s'),

            'start_time' =>  '16:00:00',
            'end_time' => '17:00:00',

            // 'school_year' => fake()->randomElement(['2023-2024', '2024-2025', '2025-2026']),
            'school_year' => fake()->randomElement(['2025-2026']),
            'image' => 'null',
            'status' => 'not_finished',

        ];
    }
}
