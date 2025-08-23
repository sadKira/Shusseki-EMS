<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => str_pad(mt_rand(0, 9999999), 7, '0', STR_PAD_LEFT),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'year_level' => fake()->randomElement([
                '1st Year',
                '2nd Year',
                '3rd Year',
                '4th Year',
            ]),

            'course' => fake()->randomElement([
                'Bachelor of Arts in International Studies',
                'Bachelor of Science in Information Systems',
                'Bachelor of Human Services',
                'Bachelor of Secondary Education',
            ]),

            'role' => 'user',
            'status' => 'pending',
            'account_status' => 'active',
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'tsuushin' => 'not_member',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}