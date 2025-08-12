<x-layouts.user_app>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 lg:py-10">
        
        <flux:heading size="xl" class="max-lg:hidden font-bold whitespace-nowrap">My Profile</flux:heading>

        {{-- Mobile view --}}
        <div class="flex items-center justify-between lg:hidden whitespace-nowrap">
            <flux:heading size="xl" class="font-bold">My Profile</flux:heading>

            <!-- Desktop User Menu -->
            <flux:dropdown position="top" align="end">
                <flux:profile circle class="cursor-pointer" :initials="auth()->user()->initials()" avatar:color="auto"
                    avatar:color:seed="{{ auth()->user()->id }}" />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg ">
                                        {{-- {{ auth()->user()->initials() }} --}}
                                        <flux:icon.user variant="solid" class="text-white" />
                                    </span>
                                </span>

                                <div class="grid flex-1 text-zinc-50 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">ID: {{ auth()->user()->student_id }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </div>

        <div class="flex items-start max-md:flex-col px-10 py-6">
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