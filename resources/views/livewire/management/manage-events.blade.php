<div class="h-full rounded-lg ">
    {{-- App Header --}}
    <div class=" relative mb-10 w-full">
        {{-- Breadcrumbs --}}
        <div class="mt-2 flex">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_events')" wire:navigate>Events
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_events')" :accent="true" wire:navigate>
                    <span class="text-[var(--color-accent)]">Manage Events<span>
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <flux:heading size="xl" level="1">Manage Events</flux:heading>
    </div>


    {{-- Events --}}
    <div class="flex items-start gap-3">

        {{-- Left side --}}
        <div class="flex flex-col gap-3 w-full">

            {{-- Events for the month --}}
            <div class="px-10 py-6 bg-(--import) rounded-xl">
                <section class="w-full flex items-center justify-start gap-2">
                    <div class="flex items-center gap-2">
                        {{-- <span class="w-2 h-2 bg-white inline-block"></span> --}}
                        <flux:heading size="xl" level="1">Events this <span
                                class="text-[var(--color-accent)]">{{ $selectedMonth }}</span></flux:heading>
                    </div>

                    {{-- <flux:dropdown>
                        <flux:button variant="filled" icon="chevron-down" size="sm"></flux:button>
                        <flux:menu>
                            <flux:menu.radio.group wire:model.live="selectedMonth">
                                <flux:menu.radio checked value="January">January</flux:menu.radio>
                                <flux:menu.radio value="February">February</flux:menu.radio>
                                <flux:menu.radio value="March">March</flux:menu.radio>
                                <flux:menu.radio value="April">April</flux:menu.radio>
                                <flux:menu.radio value="May">May</flux:menu.radio>
                                <flux:menu.radio value="June">June</flux:menu.radio>
                                <flux:menu.radio value="July">July</flux:menu.radio>
                                <flux:menu.radio value="August">August</flux:menu.radio>
                                <flux:menu.radio value="September">September</flux:menu.radio>
                                <flux:menu.radio value="October">October</flux:menu.radio>
                                <flux:menu.radio value="November">November</flux:menu.radio>
                                <flux:menu.radio value="December">December</flux:menu.radio>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown> --}}
                </section>

                {{-- Events content --}}
                <div
                    class="h-80 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">
                    <div class="mt-5 flex flex-col gap-2 w-full">
                        @forelse ($events as $event)
                            <div
                                class="p-4 mr-4 flex items-center justify-between rounded-2xl dark:bg-zinc-900 dark:border-zinc-700 dark:hover:bg-zinc-800">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <img src="https://picsum.photos/seed/{{ rand(0, 100000) }}/40/40" alt=""
                                            class="rounded-xl">
                                    </div>
                                    <div class="">
                                        <flux:text variant="strong">{{ $event->title }}</flux:text>
                                        <flux:text variant="subtle">
                                            {{ \Carbon\Carbon::parse($event->date)->format('Y, F j') }} |
                                            {{  \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} -
                                            {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                        </flux:text>
                                    </div>
                                </div>
                                <div class="flex-items-center">
                                    @php
                                        $timezone = 'Asia/Manila';
                                        $now = now()->timezone($timezone);
                                        $start = \Carbon\Carbon::today($timezone)->setTimeFromTimeString($event->start_time);
                                        $end = \Carbon\Carbon::today($timezone)->setTimeFromTimeString($event->end_time);
                                    @endphp
                                    @if ($now->between($start, $end))
                                        <flux:badge color="amber" class="mr-10" variant="solid"><span class="text-black">In
                                                Progress</span></flux:badge>
                                    @endif
                                    @if ($event->status == \App\Enums\EventStatus::Finished)
                                        <flux:badge color="green" class="mr-10" variant="solid"><span
                                                class="text-black">Ended</span></flux:badge>
                                    @endif
                                    @if ($event->status == \App\Enums\EventStatus::Postponed)
                                        <flux:badge color="red" class="mr-10" variant="solid"><span
                                                class="text-white">Postponed</span></flux:badge>
                                    @endif
                                    <flux:button variant="ghost" icon="ellipsis-horizontal"></flux:button>
                                </div>

                            </div>
                        @empty
                            <x-empty-state />
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Events for the next month --}}
            <div class="px-10 py-6 bg-(--import) rounded-xl">
                <section class="w-full flex items-center justify-start gap-2">
                    <div class="flex items-center gap-2">
                        {{-- <span class="w-2 h-2 bg-white inline-block"></span> --}}
                        <flux:heading size="xl" level="1">Events next month: <span
                                class="text-[var(--color-accent)]">{{ \Carbon\Carbon::parse($selectedMonth)->addMonth()->format('F') }}</span>
                        </flux:heading>
                    </div>
                </section>

                {{-- Events content --}}
                <div
                    class="h-80 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">
                    <div class="mt-5 flex flex-col gap-2 w-full">
                        @forelse ($this->nextMonthEvents as $event)
                            <div
                                class="p-4 mr-4 flex items-center justify-between rounded-2xl dark:bg-zinc-900 dark:border-zinc-700 dark:hover:bg-zinc-800">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <img src="https://picsum.photos/seed/{{ rand(0, 100000) }}/40/40" alt=""
                                            class="rounded-xl">
                                    </div>
                                    <div class="">
                                        <flux:text variant="strong">{{ $event->title }}</flux:text>
                                        <flux:text variant="subtle">
                                            {{ \Carbon\Carbon::parse($event->date)->format('Y, F j') }} |
                                            {{  \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} -
                                            {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                        </flux:text>
                                    </div>
                                </div>
                                <div class="flex-items-center">
                                    @php
                                        $timezone = 'Asia/Manila';
                                        $now = now()->timezone($timezone);
                                        $start = \Carbon\Carbon::today($timezone)->setTimeFromTimeString($event->start_time);
                                        $end = \Carbon\Carbon::today($timezone)->setTimeFromTimeString($event->end_time);
                                    @endphp
                                    @if ($now->between($start, $end))
                                        <flux:badge color="amber" class="mr-10" variant="solid"><span class="text-black">In
                                                Progress</span></flux:badge>
                                    @endif
                                    @if ($event->status == \App\Enums\EventStatus::Finished)
                                        <flux:badge color="green" class="mr-10" variant="solid"><span
                                                class="text-black">Ended</span></flux:badge>
                                    @endif
                                    @if ($event->status == \App\Enums\EventStatus::Postponed)
                                        <flux:badge color="red" class="mr-10" variant="solid"><span
                                                class="text-white">Postponed</span></flux:badge>
                                    @endif
                                    <flux:button variant="ghost" icon="ellipsis-horizontal"></flux:button>
                                </div>

                            </div>
                        @empty
                            <x-empty-state />
                        @endforelse
                    </div>
                </div>
                
            </div>

        </div>


        {{-- Right side --}}
        <div class="flex flex-col gap-3">

            {{-- Date --}}
            <div class="bg-(--import) rounded-xl px-10 py-6 flex flex-col gap-3">
                <div class="flex flex-col  whitespace-nowrap">
                    <flux:text>Date:</flux:text>
                    <div class="flex items-center gap-2">
                        <flux:icon.calendar class="text-zinc-50" variant="solid" />
                        <flux:heading size="xl" level="1">{{ \Carbon\Carbon::now()->format('l, F j') }}</flux:heading>
                        {{-- <flux:heading size="xl" level="1">Monday, December 2</flux:heading> --}}
                    </div>
                </div>

                <div class="flex flex-col">
                    <flux:text>Academic Year:</flux:text>
                    <div class="flex items-center gap-2">
                        <flux:icon.presentation-chart-line class="text-zinc-50" variant="solid" />
                        <flux:heading size="xl" level="1">{{ $selectedSchoolYear }}</flux:heading>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-(--import) rounded-xl px-10 py-6 h-full">
                <div class="h-147 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">
                    <div class="mr-3">
                        @forelse ($this->groupedEvents as $date => $events)
                            <!-- Heading -->
                            <div class="ps-2 my-2 first:mt-0">
                                <h3 class="text-xs font-medium uppercase text-zinc-500 dark:text-zinc-400">
                                    {{ \Carbon\Carbon::parse($date)->format('F j') }}
                                </h3>
                            </div>
                            <!-- End Heading -->

                            @foreach ($events as $event)
                                <!-- Item -->
                                <div class="flex gap-x-3">
                                    <!-- Icon -->
                                    <div
                                        class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-zinc-200 dark:after:bg-zinc-700">
                                        <div class="relative z-10 size-7 flex justify-center items-center">
                                            <div class="size-2 rounded-full bg-zinc-400 dark:bg-zinc-600"></div>
                                        </div>
                                    </div>
                                    <!-- End Icon -->

                                    <!-- Right Content -->
                                    <div class="grow pt-0.5 pb-8">
                                        <h3 class="flex gap-x-1.5 font-semibold text-zinc-800 dark:text-white">
                                            {{ $event->title }}
                                        </h3>
                                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400 text-balance">
                                            {{  \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} -
                                            {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                        </p>
                                        @if ($now->between($start, $end))
                                            <flux:badge color="amber" class="mt-3" variant="solid"><span class="text-black">In
                                                    Progress</span></flux:badge>
                                        @endif
                                        @if ($event->status == \App\Enums\EventStatus::Finished)
                                            <flux:badge color="green" size="sm" class="mt-3" variant="solid"><span
                                                    class="text-black">Ended</span></flux:badge>
                                        @endif
                                        @if ($event->status == \App\Enums\EventStatus::Postponed)
                                            <flux:badge color="red" class="mt-3" size="sm" variant="solid"><span
                                                    class="text-white">Postponed</span></flux:badge>
                                        @endif
                                    </div>
                                    <!-- End Right Content -->
                                </div>
                                <!-- End Item -->
                            @endforeach
                        @empty
                            {{-- Empty state display --}}
                            <div class="p-5 h-full flex flex-col justify-center items-center text-center">
                                <svg class="w-48 mx-auto mb-4" width="178" height="90" viewBox="0 0 178 90" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="27" y="50.5" width="124" height="39" rx="7.5" fill="currentColor"
                                        class="fill-white dark:fill-neutral-800" />
                                    <rect x="27" y="50.5" width="124" height="39" rx="7.5" stroke="currentColor"
                                        class="stroke-gray-50 dark:stroke-neutral-700/10" />
                                    <rect x="34.5" y="58" width="24" height="24" rx="4" fill="currentColor"
                                        class="fill-gray-50 dark:fill-neutral-700/30" />
                                    <rect x="66.5" y="61" width="60" height="6" rx="3" fill="currentColor"
                                        class="fill-gray-50 dark:fill-neutral-700/30" />
                                    <rect x="66.5" y="73" width="77" height="6" rx="3" fill="currentColor"
                                        class="fill-gray-50 dark:fill-neutral-700/30" />
                                    <rect x="19.5" y="28.5" width="139" height="39" rx="7.5" fill="currentColor"
                                        class="fill-white dark:fill-neutral-800" />
                                    <rect x="19.5" y="28.5" width="139" height="39" rx="7.5" stroke="currentColor"
                                        class="stroke-gray-100 dark:stroke-neutral-700/30" />
                                    <rect x="27" y="36" width="24" height="24" rx="4" fill="currentColor"
                                        class="fill-gray-100 dark:fill-neutral-700/70" />
                                    <rect x="59" y="39" width="60" height="6" rx="3" fill="currentColor"
                                        class="fill-gray-100 dark:fill-neutral-700/70" />
                                    <rect x="59" y="51" width="92" height="6" rx="3" fill="currentColor"
                                        class="fill-gray-100 dark:fill-neutral-700/70" />
                                    <g filter="url(#empty-state-theme)">
                                        <rect x="12" y="6" width="154" height="40" rx="8" fill="currentColor"
                                            class="fill-white dark:fill-neutral-800" shape-rendering="crispEdges" />
                                        <rect x="12.5" y="6.5" width="153" height="39" rx="7.5" stroke="currentColor"
                                            class="stroke-gray-100 dark:stroke-neutral-700/60" shape-rendering="crispEdges" />
                                        <rect x="20" y="14" width="24" height="24" rx="4" fill="currentColor"
                                            class="fill-gray-200 dark:fill-neutral-700" />
                                        <rect x="52" y="17" width="60" height="6" rx="3" fill="currentColor"
                                            class="fill-gray-200 dark:fill-neutral-700" />
                                        <rect x="52" y="29" width="106" height="6" rx="3" fill="currentColor"
                                            class="fill-gray-200 dark:fill-neutral-700" />
                                    </g>
                                    <defs>
                                        <filter id="empty-state-theme" x="0" y="0" width="178" height="64" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                result="hardAlpha" />
                                            <feOffset dy="6" />
                                            <feGaussianBlur stdDeviation="6" />
                                            <feComposite in2="hardAlpha" operator="out" />
                                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0" />
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1187_14810" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1187_14810" result="shape" />
                                        </filter>
                                    </defs>
                                </svg>
                                <div class="max-w-sm mx-auto">
                                    <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">No Events for {{ $selectedMonth }}</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- End Timeline -->
        </div>

    </div>


    <script>
        // // Initialize carousel on first load
        // document.addEventListener('livewire:load', function () {
        //     if (window.HSStaticMethods) {
        //         window.HSStaticMethods.autoInit();
        //     }
        // });

        // // Re-initialize carousel after each Livewire update
        // document.addEventListener('livewire:update', function () {
        //     if (window.HSStaticMethods) {
        //         window.HSStaticMethods.autoInit();
        //     }
        // });

        // // Also re-initialize on navigation
        // document.addEventListener('livewire:navigate', function () {
        //     if (window.HSStaticMethods) {
        //         window.HSStaticMethods.autoInit();
        //     }
        // });

        window.HSStaticMethods.autoInit();
    </script>

</div>