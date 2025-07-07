<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Tag;
use App\Models\Setting;

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
            TsuushinSeeder::class,
            SchoolYearSeeder::class,
        ]);

        User::factory(10)->create();

        $tags = collect([
            Tag::updateOrCreate(['tag' => 'required']),
            Tag::updateOrCreate(['tag' => 'not_required']),
        ]);

        Event::factory(20)
            ->hasAttached($tags) 
            ->create();

        Setting::create([
            'key' => 'current_school_year',
            'value' => '2024-2025',
        ]);
    }
}
