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
        <flux:input wire:model="name" :label="__('Full Name')" badge="Last Name, First Name, M.I." type="text" required
            autofocus autocomplete="name" :placeholder="__('Full name')" />

        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email address')" type="email" required autocomplete="email"
            placeholder="email@example.com" />

        {{-- Year Level & Course --}}
        <div class="grid grid-cols-2 gap-x-4 gap-y-6">
            <flux:select wire:model="year_level" :label="__('Year level')" :placeholder="__('Your year level')"
                required>
                <option>1st Year</option>
                <option>2nd Year</option>
                <option>3rd Year</option>
                <option>4th Year</option>
            </flux:select>

            <flux:select wire:model="course" :label="__('Course')" :placeholder="__('Your course')" required>
                <option>Bachelor of Arts in International Studies</option>
                <option>Bachelor of Science in Information Systems</option>
                <option>Bachelor of Human Services</option>
                <option>Bachelor of Secondary Education</option>
            </flux:select>
        </div>

        <!-- Password -->
        <flux:input wire:model="password" :label="__('Password')" type="password" required autocomplete="new-password"
            :placeholder="__('Password')" viewable />

        <!-- Confirm Password -->
        <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" required
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