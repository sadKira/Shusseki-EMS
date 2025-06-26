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


<body class="min-h-screen bg-white dark:bg-zinc-800 font-display">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        {{-- <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse"
            wire:navigate>

        </a> --}}
        <x-app-logo />

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">

                {{-- Dashboard --}}
                @can('manage')
                    <flux:navlist.item icon="home" :href="route('admin_dashboard')"
                        :current="request()->routeIs(['admin_dashboard'])" wire:navigate>{{ __('Dashboard') }}
                    </flux:navlist.item>
                    <flux:navlist.group heading="Events" expandable>
                        <flux:navlist.item icon="calendar" :href="route('manage_events')"
                            :current="request()->routeIs(['manage_events'])" wire:navigate>
                            {{ __('Manage Events') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="envelope" :href="route('coverage_events')"
                            :current="request()->routeIs(['coverage_events'])" wire:navigate>
                            {{ __('Events Coverage') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                    <flux:navlist.item icon="user" :href="route('manage_students')"
                        :current="request()->routeIs(['manage_students', 'manage_approval'])" wire:navigate>
                        {{ __('Students') }}
                    </flux:navlist.item>
                @endcan

                @can('tsuushin_dashboard')
                    <flux:navlist.item icon="home" :href="route('tsuushin_dashboard')"
                        :current="request()->routeIs(['tsuushin_dashboard'])" wire:navigate>{{ __('Dashboard') }}
                    </flux:navlist.item>
                @endcan
                @can('dashboard')
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs(['dashboard'])"
                        wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                @endcan

            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-zinc-50 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
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
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:navbar class="lg:hidden w-full">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
        </flux:navbar>
        <flux:navbar scrollable>
            <flux:dropdown position="top" align="end">
                <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-zinc-50 text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                        </flux:menu.item>
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
        </flux:navbar>
    </flux:header>
    {{-- <flux:header
        class="block! bg-white lg:bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
        <flux:navbar class="lg:hidden w-full">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

        </flux:navbar>

        <flux:navbar scrollable>
            <flux:navbar.item href="#" current>Dashboard</flux:navbar.item>
            <flux:navbar.item badge="32" href="#">Orders</flux:navbar.item>
            <flux:navbar.item href="#">Catalog</flux:navbar.item>
            <flux:navbar.item href="#">Configuration</flux:navbar.item>
        </flux:navbar>
    </flux:header> --}}

    {{ $slot }}


    @fluxScripts
    @livewireScripts
</body>

</html>