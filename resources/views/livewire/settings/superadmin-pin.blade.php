<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Admin Key')" :subheading="__('Update your 4-digit admin key')">
        <div class="mt-6 space-y-6">

            {{-- Current Admin Key --}}
            <flux:heading>Current Admin Key</flux:heading>
            <div class="flex gap-x-5" id="pin-current" wire:ignore data-hs-pin-input='{
                 "availableCharsRE": "^[0-9]+$"

                }'>
                <input
                    class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                    type="password" placeholder="○" data-hs-pin-input-item="" autofocus="">
                <input
                    class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                    type="password" placeholder="○" data-hs-pin-input-item="" >
                <input
                    class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                    type="password" placeholder="○" data-hs-pin-input-item="" >
                <input
                    class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                    type="password" placeholder="○" data-hs-pin-input-item="" >

            </div>

            @error('current_admin_key')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            {{-- New Admin Key --}}
            <flux:heading>New Admin Key</flux:heading>
            <div class="flex gap-x-5" id="pin-new" wire:ignore data-hs-pin-input='{
                 "availableCharsRE": "^[0-9]+$"
                 
                 
                }'>
                <input
                    class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                    type="text" placeholder="○" data-hs-pin-input-item="" >
                <input
                    class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                    type="text" placeholder="○" data-hs-pin-input-item="">
                <input
                    class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                    type="text" placeholder="○" data-hs-pin-input-item="" >
                <input
                    class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                    type="text" placeholder="○" data-hs-pin-input-item="" >

            </div>

            @error('new_admin_key')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            {{-- Confirm Admin Key --}}
            <flux:heading>Confirm Admin Key</flux:heading>
            <div class="flex gap-x-5" id="pin-confirm" wire:ignore data-hs-pin-input='{
                 "availableCharsRE": "^[0-9]+$"
                 
                }'>
                <input
                    class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                    type="text" placeholder="○" data-hs-pin-input-item="" >
                <input
                    class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                    type="text" placeholder="○" data-hs-pin-input-item="" >
                <input
                    class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                    type="text" placeholder="○" data-hs-pin-input-item="" >
                <input
                    class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                    type="text" placeholder="○" data-hs-pin-input-item="" >

            </div>

            @error('admin_key_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror




            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" wire:click="updateAdminKey" class="w-full">{{ __('Save') }}
                    </flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </div>
    </x-settings.layout>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ensure Preline PIN inputs are initialized
            if (window.HSPinInput) {
                window.HSPinInput.autoInit();
            } else {
                console.error("❌ Preline HSPinInput not available.");
                return;
            }

            // Bind each PIN input to a Livewire property
            const bindings = [
                { id: 'pin-current', model: 'current_admin_key' },
                { id: 'pin-new', model: 'new_admin_key' },
                { id: 'pin-confirm', model: 'admin_key_confirmation' },
            ];

            bindings.forEach(({ id, model }) => {
                const el = document.getElementById(id);
                if (!el) {
                    console.warn(`⚠️ Element with ID "${id}" not found.`);
                    return;
                }

                const instance = window.HSPinInput.getInstance(`#${id}`);
                if (!instance) {
                    console.warn(`⚠️ HSPinInput instance not found for #${id}`);
                    return;
                }

                instance.on('completed', ({ currentValue }) => {
                    let pinValue = Array.isArray(currentValue)
                        ? currentValue.join('')
                        : currentValue;

                    // console.log(`✅ ${model} set to:`, pinValue);

                    // Send the pin value to Livewire
                    @this.set(model, pinValue);
                });
            });

            // Listen for reset from Livewire
            window.addEventListener('admin-key-updated', () => {
                bindings.forEach(({ id }) => {
                    const container = document.getElementById(id);
                    if (!container) return;

                    const inputs = container.querySelectorAll('input[data-hs-pin-input-item]');
                    inputs.forEach(input => input.value = '');
                });
            });
        });
    </script>






</section>