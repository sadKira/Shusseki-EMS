<div class="flex items-start max-md:flex-col px-10 py-6 metallic-card-soft rounded-xl">
    <div class="me-10 w-full pb-4 md:w-[220px]">

        <flux:navlist>

            <flux:navlist.group heading="Account Settings" class="mt-4">

                @livewire('settings.profile-tab', ['currentRoute' => \Route::currentRouteName()])
                @livewire('settings.password-tab', ['currentRoute' => \Route::currentRouteName()])

                @can('dark_mode')
                    <flux:navlist.item :href="route('settings.appearance')" wire:navigate>{{ __('Appearance') }}
                    </flux:navlist.item>
                @endcan
            </flux:navlist.group>
            @can('SA')
                <flux:navlist.group heading="Super Administrator" class="mt-4">
                    @livewire('settings.schoolyear-tab', ['currentRoute' => \Route::currentRouteName()])
                    @livewire('settings.sakey-tab', ['currentRoute' => \Route::currentRouteName()])
                </flux:navlist.group>
            @endcan

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