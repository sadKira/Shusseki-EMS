<div class="flex flex-col gap-6">
    {{-- <x-auth-header :title="__('Create an account')"
        :description="__('Enter your details below to create your account')" /> --}}
    <div class="flex w-full flex-col text-center">
        <flux:heading size="xl">Create an account</flux:heading>
        <flux:subheading>Enter your details below to create your account</flux:subheading>
    </div>
    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input wire:model.defer="name" :label="__('Full Name')" badge="Last Name, First Name, M.I." type="text" required
            autofocus autocomplete="name" :placeholder="__('Full name')" />

        <!-- Email Address -->
        <flux:input wire:model.defer="email" :label="__('Email address')" type="email" required autocomplete="email"
            placeholder="email@example.com" />

        <!-- Student ID -->
        <flux:input wire:model.defer="student_id" :label="__('Student ID')" type="text" required :placeholder="__('Enter 7-Digit ID')"  mask="9999999" />

        {{-- Year Level & Course --}}
        <div class="grid grid-cols-2 gap-x-4 gap-y-6">
            <flux:select wire:model.defer="year_level" :label="__('Year level')" :placeholder="__('Your Year Level')"
                >
                {{-- <flux:select.option value="">Your Year Level</flux:select.option> --}}
                <flux:select.option value="1st Year">1st Year</flux:select.option>
                <flux:select.option value="2nd Year">2nd Year</flux:select.option>
                <flux:select.option value="3rd Year">3rd Year</flux:select.option>
                <flux:select.option value="4th Year">4th Year</flux:select.option>
            </flux:select>

            <flux:select wire:model.defer="course" :label="__('Course')" :placeholder="__('Your course')" required>
                <flux:select.option value="Bachelor of Arts in International Studies">Bachelor of Arts in International Studies</flux:select.option>
                <flux:select.option value="Bachelor of Science in Information Systems">Bachelor of Science in Information Systems</flux:select.option>
                <flux:select.option value="Bachelor of Human Services">Bachelor of Human Services</flux:select.option>
                <flux:select.option value="Bachelor of Secondary Education">Bachelor of Secondary Education</flux:select.option>
            </flux:select>
        </div>

        <!-- Password -->
        <flux:input wire:model.defer="password" :label="__('Password')" type="password" required autocomplete="new-password"
            :placeholder="__('Password')" viewable />

        <!-- Confirm Password -->
        <flux:input wire:model.defer="password_confirmation" :label="__('Confirm password')" type="password" required
            autocomplete="new-password" :placeholder="__('Confirm password')" viewable />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>