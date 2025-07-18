<div class="flex items-start max-md:flex-col px-10 py-6 bg-(--import) rounded-xl">
    <div class="me-10 w-full pb-4 md:w-[220px]">

        <flux:navlist>

            <flux:navlist.group heading="Account Settings" class="mt-4">
                <flux:navlist.item :href="route('settings.profile')" wire:navigate
                :current="request()->routeIs(['settings.profile'])">{{ __('Profile') }}</flux:navlist.item>
                <flux:navlist.item :href="route('settings.password')" wire:navigate
                :current="request()->routeIs(['settings.password'])">{{ __('Password') }}</flux:navlist.item>

                @can('dark_mode')
                    <flux:navlist.item :href="route('settings.appearance')" wire:navigate>{{ __('Appearance') }}</flux:navlist.item>
                @endcan
            </flux:navlist.group>
            <flux:navlist.group heading="Set Academic Year" class="mt-4">
                <flux:navlist.item :href="route('settings.schoolyear')" wire:navigate
                :current="request()->routeIs(['settings.schoolyear'])">{{ __('Academic Year') }}</flux:navlist.item>
            </flux:navlist.group>

        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
