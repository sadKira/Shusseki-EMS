<?php

namespace App\Livewire\Settings;

use Livewire\Component;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;

class SuperadminPin extends Component
{

    public string $current_admin_key = '';

    public string $new_admin_key = '';

    public string $admin_key_confirmation = '';


    public function updateAdminKey(): void
    {
        $this->validate([
            'current_admin_key' => ['required', 'string'],
            'new_admin_key' => ['required', 'string', 'same:admin_key_confirmation'],
            'admin_key_confirmation' => ['required', 'string'],
        ]);

        $setting = Setting::where('key', 's_a_k')->first();

        if (!$setting || !Hash::check($this->current_admin_key, $setting->value)) {
            throw ValidationException::withMessages([
                'current_admin_key' => ['The current admin key is incorrect.'],
            ]);
        }

        $setting->update([
            'value' => Hash::make($this->new_admin_key),
        ]);

        $this->reset(['current_admin_key', 'new_admin_key', 'admin_key_confirmation']);
        $this->resetErrorBag();

        $this->dispatch('password-updated');
        $this->dispatch('admin-key-updated');
    }


    public function render()
    {
        return view('livewire.settings.superadmin-pin');
    }
}
