<div>
    <flux:heading>Edit Profile</flux:heading>
    <flux:subheading>Only the email and year level can be updated</flux:subheading>

    <div class="mt-5 w-full max-w-lg">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">

            <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                {{-- Locked name --}}
                <flux:input type="text" wire:model="name" icon:trailing="lock-closed" readonly :label="__('Name')"/>

                {{-- Locked student id --}}
                <flux:input type="text"  wire:model="student_id" icon:trailing="lock-closed" readonly :label="__('Student ID')"/>
            </div>

            {{-- Editable email --}}
            <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" autofocus />

            {{-- Locked course and editable year level --}}
            <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                <flux:select wire:model="year_level" :label="__('Year level')">
                    <flux:select.option value="1st Year">1st Year</flux:select.option>
                    <flux:select.option value="2nd Year">2nd Year</flux:select.option>
                    <flux:select.option value="3rd Year">3rd Year</flux:select.option>
                    <flux:select.option value="4th Year">4th Year</flux:select.option>
                </flux:select>

                <flux:input type="text"  wire:model="course" icon:trailing="lock-closed" readonly :label="__('Course')"/>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

    </div>
</div>