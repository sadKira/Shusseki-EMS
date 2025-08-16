<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Admin Key')" :subheading="__('Update your 4-digit admin key')">
        <div class="mt-6 space-y-6">

            {{-- Current Admin Key --}}
            <div>
                <flux:heading class="mb-2">Current Admin Key</flux:heading>
                <div class="flex items-center gap-5">
                    <div class="flex gap-x-5" id="pin-current" wire:ignore data-hs-pin-input='{
                        "availableCharsRE": "^[0-9]+$"

                        }'>
                        <input
                            class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            type="password" placeholder="○" data-hs-pin-input-item="">
                        <input
                            class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            type="password" placeholder="○" data-hs-pin-input-item="">
                        <input
                            class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            type="password" placeholder="○" data-hs-pin-input-item="">
                        <input
                            class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            type="password" placeholder="○" data-hs-pin-input-item="">

                    </div>

                    @error('current_admin_key')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>
            </div>

                

            {{-- New Admin Key --}}
            <div>
                <flux:heading class="mb-2">New Admin Key</flux:heading>
                <div class="flex items-center gap-5">
                    <div class="flex gap-x-5" id="pin-new" wire:ignore data-hs-pin-input='{
                        "availableCharsRE": "^[0-9]+$"
                        
                        }'>
                        <input
                            class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            type="text" placeholder="○" data-hs-pin-input-item="">
                        <input
                            class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            type="text" placeholder="○" data-hs-pin-input-item="">
                        <input
                            class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            type="text" placeholder="○" data-hs-pin-input-item="">
                        <input
                            class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            type="text" placeholder="○" data-hs-pin-input-item="">

                    </div>

                    @error('new_admin_key')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            

            {{-- Confirm Admin Key --}}
            <div>
                <flux:heading class="mb-2">Confirm Admin Key</flux:heading>
                <div class="flex items-center gap-5">
                    <div class="flex gap-x-5" id="pin-confirm" wire:ignore data-hs-pin-input='{
                        "availableCharsRE": "^[0-9]+$"
                        
                        }'>
                        <input
                            class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            type="password" placeholder="○" data-hs-pin-input-item="">
                        <input
                            class="block w-9.5 tpasswordcenter border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            type="password" placeholder="○" data-hs-pin-input-item="">
                        <input
                            class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            type="password" placeholder="○" data-hs-pin-input-item="">
                        <input
                            class="block w-9.5 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            type="password" placeholder="○" data-hs-pin-input-item="">

                    </div>

                    @error('admin_key_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Admin Key Update button --}}
            <div x-data="{ shown: false }" x-init="
                    @this.on('password-updated', () => {
                        shown = true;
                        setTimeout(() => { shown = false }, 2000);
                    })
                " class="">

                <!-- Button (default, shown when callout is hidden) -->
                <template x-if="!shown">
                    <flux:button variant="primary" wire:click="updateAdminKey" class="w-full">{{ __('Update Admin Key') }}</flux:button>
                </template>

                <!-- Callout (shown temporarily when event fires) -->
                <template x-if="shown">
                    <flux:callout variant="success" icon="check-circle" heading="Admin Key Updated" />
                </template>

            </div>
        </div>
    </x-settings.layout>

    <script>
        function initAdminPinInputs() {
            const bindings = [
                { id: 'pin-current', model: 'current_admin_key' },
                { id: 'pin-new', model: 'new_admin_key' },
                { id: 'pin-confirm', model: 'admin_key_confirmation' },
            ];

            if (!window.HSPinInput || typeof window.HSPinInput.autoInit !== 'function') {
                console.error("❌ Preline HSPinInput is not available.");
                return;
            }

            window.HSPinInput.autoInit();

            bindings.forEach(({ id, model }) => {
                const instance = window.HSPinInput.getInstance(`#${id}`);
                if (!instance) {
                    console.warn(`⚠️ Could not find HSPinInput instance for #${id}`);
                    return;
                }

                instance.on('completed', ({ currentValue }) => {
                    const pinValue = Array.isArray(currentValue)
                        ? currentValue.join('')
                        : currentValue;

                    @this.set(model, pinValue);
                });
            });

            // Listen for Livewire-triggered reset
            window.addEventListener('admin-key-updated', () => {
                bindings.forEach(({ id }) => {
                    const container = document.getElementById(id);
                    if (!container) return;

                    const inputs = container.querySelectorAll('input[data-hs-pin-input-item]');
                    inputs.forEach(input => input.value = '');
                    if (inputs[0]) inputs[0].focus();
                });
            });
        }

        // Initial load
        document.addEventListener('DOMContentLoaded', initAdminPinInputs);

        // Re-init after Livewire navigation or DOM updates
        document.addEventListener('livewire:navigated', initAdminPinInputs);
        document.addEventListener('livewire:load', initAdminPinInputs);

    </script>







</section>