<x-layouts.user_app>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 lg:py-10">
        
        <flux:heading size="xl" class="font-bold whitespace-nowrap">My <span class="text-[var(--color-accent)]">Profile</span></flux:heading>

        <div class="flex items-start max-md:flex-col py-6">
            <div class="me-10 w-full pb-4 md:w-[220px]">

                <flux:navlist>

                    <flux:navlist.group  class="mt-4">

                        @livewire('user.main-profile-tab', ['currentRoute' => \Route::currentRouteName()])
                        @livewire('user.edit-profile-tab', ['currentRoute' => \Route::currentRouteName()])
                        @livewire('user.password-tab', ['currentRoute' => \Route::currentRouteName()])

                        {{-- @can('dark_mode')
                            <flux:navlist.item :href="route('settings.appearance')" wire:navigate>{{ __('Appearance') }}
                            </flux:navlist.item>
                        @endcan --}}
                    </flux:navlist.group>

                </flux:navlist>
            </div>

            <flux:separator class="md:hidden" />

            <div class="flex-1 self-stretch max-md:pt-6">
                {{ $slot }}
            </div>
        </div>



    </div>

</x-layouts.user_app>