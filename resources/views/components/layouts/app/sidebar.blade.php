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

    {{-- dark:border-zinc-700 dark:bg-zinc-900 --}}
    {{-- antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 --}}
    {{-- <flux:sidebar sticky stashable class=" border-zinc-900 dark:bg-zinc-950 border-r" style=" background: linear-gradient(180deg, #0f0f0f, #18181b 70%);"> --}}
    <flux:sidebar sticky stashable class="border-r border-zinc-800 dark:bg-zinc-950">
        {{-- style="background: linear-gradient(
            135deg,
            rgba(255, 240, 220, 0.05),
            rgba(255, 255, 255, 0) 60%
        ),
        linear-gradient(
            180deg,
            #11100e 0%, 
            #0c0a09 70%
        );"> --}}
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        {{-- <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse"
            wire:navigate>

        </a> --}}
        <x-app-logo />

        <flux:navlist variant="outline">

            {{-- Home navlist --}}
            <flux:navlist.group :heading="__('Home')" class="grid">

                {{-- Dashboard --}}
                @can('manage')
                    <flux:navlist.item icon="home" :href="route('admin_dashboard')"
                        :current="request()->routeIs(['admin_dashboard'])" wire:navigate>{{ __('Dashboard') }}
                    </flux:navlist.item>
                @endcan

            </flux:navlist.group>

            {{-- Events navlist --}}
            <flux:navlist.group :heading="__('Events')" class="grid">
                @can('manage')
                    <flux:navlist.item icon="list-bullet" :href="route('event_list')"
                        :current="request()->routeIs(['event_list'])" wire:navigate>
                        {{ __('Event List') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="calendar" :href="route('manage_events')"
                        :current="request()->routeIs(['manage_events', 'create_event', 'view_event', 'edit-event'])" wire:navigate>
                        {{ __('Events Bin') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="envelope" :href="route('coverage_events')"
                        :current="request()->routeIs(['coverage_events'])" wire:navigate>
                        {{ __('Events Coverage') }}
                    </flux:navlist.item>
                @endcan
            </flux:navlist.group>

            {{-- Students navlist --}}
            <flux:navlist.group :heading="__('Students')" class="grid">
                @can('manage')
                    <flux:navlist.item icon="newspaper" :href="route('student_records')"
                        :current="request()->routeIs(['student_records'])" wire:navigate>
                        {{ __('Student Records') }}
                    </flux:navlist.item>
                    @can('SA')
                        <flux:navlist.item icon="user" :href="route('manage_students')"
                            :current="request()->routeIs(['manage_students'])" wire:navigate>
                            {{ __('Manage Students') }}
                        </flux:navlist.item>

                        {{-- Dynamic badge --}}
                        @livewire('management.manage-approval-badge', ['currentRoute' => \Route::currentRouteName()])
                    @endcan
                    @can('A')
                        <flux:navlist.item icon="user" :href="route('manage_students')"
                            :current="request()->routeIs(['manage_students'])" wire:navigate>
                            {{ __('Student List') }}
                        </flux:navlist.item>
                    @endcan
                @endcan
            </flux:navlist.group>

        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            {{-- <flux:navlist.item icon="code-bracket" :href="route('buffer_view')"
                            :current="request()->routeIs(['buffer_view'])" wire:navigate>Buffer</flux:navlist.item> --}}
            <flux:navlist.item icon="information-circle" :href="route('generate_report')"
                            :current="request()->routeIs(['generate_report'])" wire:navigate>Generate Report</flux:navlist.item>
            <flux:navlist.item icon="cog-6-tooth" :href="route('settings.profile')"
                            :current="request()->routeIs(['settings.profile', 'settings.password', 'settings.schoolyear', 'settings.sakey'])" wire:navigate>Settings</flux:navlist.item>
        </flux:navlist>

        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
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
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
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

    {{-- Main content --}}
    {{ $slot }}



    {{-- Refresh Token --}}
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

    {{-- Reinitialization --}}
    <!-- Lodash -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
    <script src="./assets/vendor/lodash/lodash.min.js"></script> --}}

    {{-- Luxon --}}
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.6.1/build/global/luxon.min.js"></script>

    {{-- Pikaday --}}
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

    <!-- Preline -->
    <script src="https://unpkg.com/preline@latest/dist/preline.js"></script>

    <!-- WebRTC -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/9.0.3/adapter.min.js"></script>

    <!-- Vue -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.5.17/vue.global.prod.min.js"></script>

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    {{-- Date time converter --}}
    <script>
        // DateTime is globally accessible only once
        if (!window.DateTime) {
            window.DateTime = luxon.DateTime;
        }
    </script>

    {{-- Initiate Date picker --}}
    <script>
        window.initDatePicker = function() {
            const field = document.getElementById('datepicker');
            if (!field || field.dataset.pikaday === 'initialized') return;

            const { DateTime } = luxon;

            const picker = new Pikaday({
                field,
                onSelect: function (date) {
                    const luxonDate = DateTime.fromJSDate(date);
                    field.value = luxonDate.toFormat('LLLL dd, yyyy');
                    field.dispatchEvent(new Event('input', { bubbles: true }));
                }
            });

            field.dataset.pikaday = 'initialized';
        }
    </script>

    {{-- Navigation Initialization --}}
    <script>
        document.addEventListener('livewire:navigated', () => {
            console.log('Livewire navigated — reinitializing scripts');

            // Re-run Pikaday initialization
            initDatePicker();

            if (window.HSDropdown && typeof window.HSDropdown.autoInit === 'function') {
                window.HSDropdown.autoInit();
            }

            if (typeof window.attachTimePickerListeners === 'function') {
                window.attachTimePickerListeners();
            }

            if (typeof window.attachTimePickerListeners2 === 'function') {
                window.attachTimePickerListeners2();
            }

            if (typeof window.attachTimePickerTimeInListeners === 'function') {
                window.attachTimePickerTimeInListeners();
            }

            // File Upload
            // if (window.HSFileUpload && typeof window.HSFileUpload.autoInit === 'function') {
            //     window.HSFileUpload.autoInit();
            // }

            // Pin Input
            // if (window.HSPinInput && typeof window.HSPinInput.autoInit === 'function') {
            //     window.HSPinInput.autoInit();
            // }


        });
    </script>


    @fluxScripts
    @livewireScripts

</body>

</html>