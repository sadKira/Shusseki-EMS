<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Models\User;

#[Layout('components.user.layout')]
class EditProfile extends Component
{
    public string $name = '';
    public string $student_id = '';
    public string $email = '';
    public string $year_level= '';
    public string $course= '';

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->year_level = Auth::user()->year_level;
        $this->course = Auth::user()->course;
        $this->student_id = Auth::user()->student_id;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            // 'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],

            'year_level' => [
                'required',
                'string',
                
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);

    }
    public function render()
    {
        return view('livewire.user.edit-profile');
    }
}
