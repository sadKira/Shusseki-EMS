<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Tag;

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
            TsuushinSeeder::class
        ]);

        User::factory(2)->create();

        $tags = collect([
            Tag::create(['tag' => 'required']),
            Tag::create(['tag' => 'not_required']),
        ]);

        Event::factory(10)
            ->hasAttached($tags) 
            ->create();

    }
}

