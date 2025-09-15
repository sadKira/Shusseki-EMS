<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class ForgotPassword extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $this->ensureIsNotRateLimited();

        Password::sendResetLink($this->only('email'));

        RateLimiter::clear($this->throttleKey());

        // session()->flash('status', __('A reset link will be sent if the account exists.'));
        $this->dispatch('forgot-password');
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());
        $this->addError('email', __('auth.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
        ]));

        abort(429);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip().'|password-reset');
    }
}
