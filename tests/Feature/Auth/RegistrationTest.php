<?php

use App\Livewire\Auth\Register;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = Livewire::test(Register::class)
        ->set('student_id', '9999999')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('year_level', 'Test')
        ->set('course', 'Test')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('approval_pending', absolute: false));

    $this->assertAuthenticated();
});