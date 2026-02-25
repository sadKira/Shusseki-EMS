<?php

use App\Livewire\Management\CreateEvent;
use App\Livewire\Management\EditEvent;
use App\Livewire\Management\ViewEvent;
use App\Models\Event;
use App\Models\User;
use App\Models\Setting;
use App\Enums\UserRole;
use App\Enums\EventStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
    \Illuminate\Support\Facades\Cache::flush();
    Setting::updateOrCreate(['key' => 'current_school_year'], ['value' => '2024-2025']);
});

test('admin can view create event page', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin);

    $response = Livewire::test(CreateEvent::class);

    $response->assertSuccessful();
});

test('admin can create an event', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin);

    $image = UploadedFile::fake()->image('event.jpg', 800, 600);

    $response = Livewire::test(CreateEvent::class)
        ->set('title', 'Test Event')
        ->set('date', 'January 15, 2025')
        ->set('location', 'Test Location')
        ->set('time_in', '08:00 AM')
        ->set('start_time', '09:00 AM')
        ->set('end_time', '10:00 AM')
        ->set('image', $image)
        ->call('createEvent');

    $response->assertRedirect(route('event_timeline'));

    $this->assertDatabaseHas('events', [
        'title' => 'Test Event',
        'location' => 'Test Location',
    ]);

    Storage::disk('public')->assertExists('events/' . $image->hashName());
});

test('event creation requires all fields', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin);

    $response = Livewire::test(CreateEvent::class)
        ->call('createEvent');

    $response->assertHasErrors(['title', 'date', 'location', 'time_in', 'start_time', 'end_time']);
});

test('event title must be unique', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $existingEvent = Event::factory()->create(['title' => 'Existing Event']);
    $this->actingAs($admin);

    $image = UploadedFile::fake()->image('event.jpg');

    $response = Livewire::test(CreateEvent::class)
        ->set('title', 'Existing Event')
        ->set('date', 'January 15, 2025')
        ->set('location', 'Test Location')
        ->set('time_in', '08:00 AM')
        ->set('start_time', '09:00 AM')
        ->set('end_time', '10:00 AM')
        ->set('image', $image)
        ->call('createEvent');

    $response->assertHasErrors(['title']);
});

test('end time must be after start time', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin);

    $image = UploadedFile::fake()->image('event.jpg');

    $response = Livewire::test(CreateEvent::class)
        ->set('title', 'Test Event')
        ->set('date', 'January 15, 2025')
        ->set('location', 'Test Location')
        ->set('time_in', '08:00 AM')
        ->set('start_time', '10:00 AM')
        ->set('end_time', '09:00 AM')
        ->set('image', $image)
        ->call('createEvent');

    $response->assertHasErrors(['end_time']);
});

test('admin can view event details', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $event = Event::factory()->create();
    $this->actingAs($admin);

    $response = Livewire::test(ViewEvent::class, ['event' => $event]);

    $response->assertSuccessful();
    expect($response->get('event')->id)->toBe($event->id);
});

test('admin can view edit event page', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $event = Event::factory()->create();
    $this->actingAs($admin);

    $response = Livewire::test(EditEvent::class, ['event' => $event]);

    $response->assertSuccessful();
    expect($response->get('title'))->toBe($event->title);
});

test('admin can update an event', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $event = Event::factory()->create(['title' => 'Original Title']);
    $this->actingAs($admin);

    $response = Livewire::test(EditEvent::class, ['event' => $event])
        ->set('title', 'Updated Title')
        ->set('location', 'Updated Location')
        ->set('date', 'February 20, 2025')
        ->set('time_in', '09:00 AM')
        ->set('start_time', '10:00 AM')
        ->set('end_time', '11:00 AM')
        ->call('updateEvent');

    // The redirect uses the event model with updated title as route key
    $event->refresh();
    // Check that redirect happened - the route uses title as key
    $response->assertRedirect();

    expect($event->title)->toBe('Updated Title');
    expect($event->location)->toBe('Updated Location');
});

test('admin can update event with new image', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $event = Event::factory()->create(['image' => 'events/old-image.jpg']);
    Storage::disk('public')->put('events/old-image.jpg', 'fake content');
    $this->actingAs($admin);

    $newImage = UploadedFile::fake()->image('new-event.jpg');

    $response = Livewire::test(EditEvent::class, ['event' => $event])
        ->set('title', $event->title)
        ->set('date', \Carbon\Carbon::parse($event->date)->format('F d, Y'))
        ->set('location', $event->location)
        ->set('time_in', \Carbon\Carbon::parse($event->time_in)->format('h:i A'))
        ->set('start_time', \Carbon\Carbon::parse($event->start_time)->format('h:i A'))
        ->set('end_time', \Carbon\Carbon::parse($event->end_time)->format('h:i A'))
        ->set('image', $newImage)
        ->call('updateEvent');

    $response->assertRedirect(route('view_event', $event));

    Storage::disk('public')->assertMissing('events/old-image.jpg');
    Storage::disk('public')->assertExists('events/' . $newImage->hashName());
});

test('admin can mark event as postponed', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $event = Event::factory()->create(['status' => EventStatus::NotFinished]);
    $this->actingAs($admin);

    $response = Livewire::test(ViewEvent::class, ['event' => $event])
        ->call('markEventAsPostponed');

    $event->refresh();
    expect($event->status)->toBe(EventStatus::Postponed);
});

test('admin can mark event as resumed', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $event = Event::factory()->create(['status' => EventStatus::Postponed]);
    $this->actingAs($admin);

    $response = Livewire::test(ViewEvent::class, ['event' => $event])
        ->call('markEventAsResumed');

    $event->refresh();
    expect($event->status)->toBe(EventStatus::NotFinished);
});

test('admin can export attendance report', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $event = Event::factory()->create();
    $user = User::factory()->create();
    \App\Models\EventAttendanceLog::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
        'attendance_status' => 'present',
    ]);
    $this->actingAs($admin);

    $response = Livewire::test(ViewEvent::class, ['event' => $event])
        ->call('exportAttendanceReport');

    $response->assertFileDownloaded("Attendance_Report_{$event->title}.pdf");
});
