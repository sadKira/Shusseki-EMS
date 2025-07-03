<?php

use App\Models\Event;
use App\Models\Tag;
use App\Models\User;
use App\Models\EventAttendanceLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('an event can have many attendance logs', function () {
    $event = Event::factory()->create();

    // Create 3 logs for this event
    EventAttendanceLog::factory()->count(3)->create([
        'event_id' => $event->id,
    ]);

    // Assert the relationship returns 3 logs
    expect($event->attendanceLogs)->toHaveCount(3);
});

it('an attendance log belongs to a user and an event', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();

    $log = EventAttendanceLog::factory()->create([
        'user_id' => $user->id,
        'event_id' => $event->id,
    ]);

    // Check reverse relationships
    expect($log->user->id)->toBe($user->id);
    expect($log->event->id)->toBe($event->id);
});

it('an event can have many tags', function () {
    $event = Event::factory()->create();
    $tags = Tag::factory()->count(2)->create();

    // Attach the tags
    $event->tags()->attach($tags->pluck('id'));

    // Assert tags are attached
    expect($event->tags)->toHaveCount(2);
});

it('a tag can belong to many events', function () {
    $tag = Tag::factory()->create();
    $events = Event::factory()->count(2)->create();

    // Attach tag to multiple events
    foreach ($events as $event) {
        $event->tags()->attach($tag->id);
    }

    // Assert the tag sees both events
    expect($tag->events)->toHaveCount(2);
});

it('a user can have multiple attendance logs', function () {
    $user = User::factory()->create();

    EventAttendanceLog::factory()->count(2)->create([
        'user_id' => $user->id,
    ]);

    expect($user->attendanceLogs()->get())->toHaveCount(2);

});

