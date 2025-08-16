<div>
    <flux:heading>Edit Profile</flux:heading>
    <flux:subheading>Only the email and year level can be updated</flux:subheading>

    <div class="mt-5 w-full max-w-lg">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">

            <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                {{-- Locked name --}}
                <flux:input type="text" wire:model="name" icon:trailing="lock-closed" readonly :label="__('Name')" />

                {{-- Locked student id --}}
                <flux:input type="text" wire:model="student_id" icon:trailing="lock-closed" readonly
                    :label="__('Student ID')" />
            </div>

            {{-- Editable email --}}
            <flux:input wire:model.defer="email" :label="__('Email')" type="email" required autocomplete="email"
                autofocus />

            {{-- Locked course and editable year level --}}
            <div class="grid md:grid-cols-2 gap-x-4 gap-y-6">
                <flux:select wire:model.defer="year_level" :label="__('Year level')">
                    <flux:select.option value="1st Year">1st Year</flux:select.option>
                    <flux:select.option value="2nd Year">2nd Year</flux:select.option>
                    <flux:select.option value="3rd Year">3rd Year</flux:select.option>
                    <flux:select.option value="4th Year">4th Year</flux:select.option>
                </flux:select>

                <flux:input type="text" wire:model="course" icon:trailing="lock-closed" readonly
                    :label="__('Course')" />
            </div>

            {{-- Profile Update button --}}
            <div x-data="{ shown: false }" x-init="
                    @this.on('profile-updated', () => {
                        shown = true;
                        setTimeout(() => { shown = false }, 2000);
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

    </div>
</div>