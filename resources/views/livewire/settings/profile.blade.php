<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Profile Update button --}}
            <div x-data="{ shown: false }" x-init="
                    @this.on('profile-updated', () => {
                        shown = true;
                        setTimeout(() => { shown = false }, 3000);
                    })
                " class="">

                <!-- Button (default, shown when callout is hidden) -->
                <template x-if="!shown">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </template>

                <!-- Callout (shown temporarily when event fires) -->
                <template x-if="shown">
                    <flux:callout variant="success" icon="check-circle" heading="Profile Updated" />
                </template>

            </div>
        </form>

    </x-settings.layout>
</section>
