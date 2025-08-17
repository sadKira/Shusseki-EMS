<!DOCTYPE html>

{{-- @can('no_dark_mode')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head_nod')
</head>
@endcan --}}

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-zinc-950 font-display">

    <flux:header container class="border-b border-zinc-800 dark:bg-zinc-950 max-lg:hidden">

        <flux:brand href="#" name="" class="font-logo">
            <x-slot name="logo" class="size-25">
                <img src="{{ asset('images/Side_White.svg') }}" alt="MKD Logo" class="">
            </x-slot>
        </flux:brand>

        <flux:navbar class="-mb-px max-lg:hidden">

            <flux:navbar.item icon="home" :href="route('dashboard')" :current="request()->routeIs(['dashboard'])"
                wire:navigate>
                {{ __('Home') }}
            </flux:navbar.item>

            <flux:navbar.item icon="calendar" :href="route('events')" :current="request()->routeIs('events')"
                wire:navigate>
                {{ __('Event Calendar') }}
            </flux:navbar.item>

            <flux:navbar.item icon="newspaper" :href="route('attendance_record')"
                :current="request()->routeIs('attendance_record')" wire:navigate>
                {{ __('Attendance Record') }}
            </flux:navbar.item>

            <flux:navbar.item icon="user" :href="route('user_main_profile')"
                :current="request()->routeIs(['user_main_profile', 'user_password', 'user_edit_profile'])"
                wire:navigate>
                {{ __('Profile') }}
            </flux:navbar.item>

        </flux:navbar>

        <flux:spacer />

        <!-- Desktop User Menu -->
        <flux:dropdown position="top" align="end">
            <flux:profile circle class="cursor-pointer" :initials="auth()->user()->initials()"
                name="{{ auth()->user()->name }}" avatar:color="auto" {{-- avatar:color:seed="{{ auth()->user()->id }}"
                --}} />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span class="flex h-full w-full items-center justify-center rounded-lg ">
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
                    <flux:menu.item as="button" type="submit" variant="danger" icon="arrow-right-start-on-rectangle"
                        class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>


    </flux:header>

    {{-- Mobile view --}}
    <flux:header container class=" bg-zinc-950 lg:hidden">
        {{-- <flux:spacer /> --}}
        <flux:brand href="#" name="" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 lg:py-10 font-logo">
            <x-slot name="logo" class="size-25">
                <img src="{{ asset('images/Side_White.svg') }}" alt="MKD Logo" class="">
            </x-slot>
        </flux:brand>
        <flux:spacer />

        <!-- Desktop User Menu -->
        <flux:dropdown position="top" align="end">
            
            <flux:button icon:trailing="bars-3" variant="ghost">Menu</flux:button>

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <flux:profile circle class="cursor-pointer" 
                                {{-- :initials="auth()->user()->initials()" --}}
                                avatar:name="{{ auth()->user()->name }}" 
                                avatar:color="auto"
                                :chevron="false"
                                {{-- color:seed="{{ auth()->user()->id }}" --}}
                                />

                            <div class="grid flex-1 text-zinc-50 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">ID: {{ auth()->user()->student_id }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />
                
                <flux:menu.item icon="home" :href="route('dashboard')" wire:navigate>Home</flux:menu.item>
                <flux:menu.item icon="calendar" :href="route('events')" wire:navigate>Event Calendar</flux:menu.item>
                <flux:menu.item icon="newspaper" :href="route('attendance_record')" wire:navigate>Attendance Record</flux:menu.item>
                <flux:menu.item icon="user" :href="route('user_main_profile')" wire:navigate>Profile</flux:menu.item>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{-- Main Content --}}
    {{ $slot }}



    <script>
        function refreshCsrfToken() {
            fetch("{{ route('refresh-csrf') }}")
                .then(response => response.json())
                .then(data => {
                    const token = data.token;
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', token);

                    // Also update Axios if you're using it
                    if (window.axios) {
                        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
                    }

                    // Livewire also uses the CSRF token from the meta tag
                });
        }

        // Refresh CSRF token every 10 minutes (600,000 ms)
        setInterval(refreshCsrfToken, 10 * 60 * 1000);
    </script>


    @fluxScripts
    @livewireScripts

</body>

</html>