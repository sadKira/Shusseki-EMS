<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input
                wire:model="current_password"
                :label="__('Current password')"
                type="password"
                required
                autocomplete="off"
                viewable
                placeholder="Enter your current password"
            />
            <flux:input
                wire:model="password"
                :label="__('New password')"
                type="password"
                required
                autocomplete="new-password"
                viewable
                placeholder="Enter a new strong password"
            />
            <flux:input
                wire:model="password_confirmation"
                :label="__('Confirm Password')"
                type="password"
                required
                autocomplete="new-password"
                viewable
                placeholder="Confirm your password"
            />

            {{-- Password Update button --}}
            <div x-data="{ shown: false }" x-init="
                    @this.on('password-updated', () => {
                        shown = true;
                        setTimeout(() => { shown = false }, 3000);
                    })
                " class="">

                <!-- Button (default, shown when callout is hidden) -->
                <template x-if="!shown">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Update Password') }}</flux:button>
                </template>

                <!-- Callout (shown temporarily when event fires) -->
                <template x-if="shown">
                    <flux:callout variant="success" icon="check-circle" heading="Password Updated" />
                </template>

            </div>
        </form>
    </x-settings.layout>
</section>
