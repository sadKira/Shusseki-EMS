<?php

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('filters events by school year', function () {
    // Create events with different school years
    Event::factory()->create(['school_year' => '2024-2025']);
    Event::factory()->create(['school_year' => '2023-2024']);
    Event::factory()->create(['school_year' => '2024-2025']);

    $eventsThisYear = Event::where('school_year', '2024-2025')->get();

    expect($eventsThisYear)->toHaveCount(2);
    expect($eventsThisYear->pluck('school_year')->unique())->toContain('2024-2025');
});

