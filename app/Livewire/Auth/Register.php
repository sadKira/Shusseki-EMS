<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Livewire;


#[Layout('components.layouts.auth')]
class Register extends Component
{

    public $name;
    public $email;
    public $student_id;
    public $year_level = '';
    public $course = '';
    public $password;
    public $password_confirmation;
    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'student_id' => ['required', 'string','unique:users,student_id', 'min:7'],
            'name' => ['required', 'string', 'min:5','max:255', 'regex:/^[A-Za-z ,.\-]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'year_level' => ['required', 'string'],
            'course' => ['required', 'string'],
        ]);

        $validated['name'] = Str::title(
            Str::lower(
                preg_replace(
                    '/,\s*/', ', ', // normalize comma spacing
                    preg_replace(
                        ['/,{2,}/', '/\.{2,}/'], // remove consecutive commas and periods
                        [',', '.'],
                        trim($validated['name'])
                    )
                )
            )
        );

        // Collapse multiple spaces into one (after normalization)
        $validated['name'] = preg_replace('/\s+/', ' ', $validated['name']);


        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        // Fire the Livewire event so badge updates
        Livewire::dispatch('refreshPendingCount')->to(\App\Livewire\Management\ManageApprovalBadge::class);

        Auth::login($user);

        $this->redirect(route('approval_pending', absolute: false), navigate: true);
    }
}
