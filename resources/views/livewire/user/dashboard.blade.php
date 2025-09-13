<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 lg:py-10">

    {{-- Detects if user is a Tsuushin Member --}}
    @if (auth()->user()->tsuushin == \App\Enums\TsuushinRole::Member)

        {{-- Upcoming Events --}}
        @if($upcomingEvents->isNotEmpty())

            <div class="mb-5">

                <div class="flex items-center gap-2 mb-5">
                    <flux:icon.camera class="text-zinc-50" variant="solid" />
                    <flux:heading size="xl" class="font-bold whitespace-nowrap">Tsuushin Coverage</flux:heading>
                </div>

                <div class="flex flex-col gap-4">
                    @foreach($upcomingEvents as $event)

                        {{-- Event Card --}}
                        <div class="relative z-50 w-auto h-auto">

                            {{-- Card Content --}}
                            <div
                                class="relative flex flex-col min-h-30 md:min-h-44 w-full overflow-hidden rounded-xl bg-zinc-950
                                                                                                                                    border border-transparent hover:border-[var(--color-accent)] group transition-colors duration-300
                                                                                                                                    ">
                                <div class="absolute inset-0 m-0 h-full w-full overflow-hidden rounded-none bg-transparent bg-cover bg-center"
                                    style="background-image: url('{{ asset('storage/' . $event->image) }}');">

                                    <div
                                        class="absolute inset-0 h-full w-full bg-gradient-to-r from-black/80 via-black/60 to-transparent">
                                    </div>
                                </div>

                                {{-- Content Main --}}
                                <div
                                    class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-0 p-10 md:px-12 h-full min-h-[120px] md:min-h-[176px] w-full">
                                    <!-- Left details -->
                                    <div class="flex flex-col gap-3">
                                        <flux:text class="font-medium text-zinc-300">
                                            {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                                        </flux:text>
                                        <h2
                                            class="text-2xl font-medium text-white leading-7 group-hover:text-[var(--color-accent)] transition-colors duration-300">
                                            {{ $event->title }}
                                        </h2>

                                        <div class="space-y-1">
                                            <div class="flex items-center gap-1">
                                                <flux:icon.clock variant="solid" class="text-zinc-300 size-4" />
                                                <flux:heading size="sm" class="text-zinc-300">
                                                    {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                                                    {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                                </flux:heading>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <flux:icon.map-pin variant="solid" class="text-zinc-300 size-4" />
                                                <flux:heading size="sm" class="text-zinc-300">
                                                    {{ $event->location }}
                                                </flux:heading>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button -->
                                    <div class="flex items-center">
                                        <flux:button class="cursor-pointer" wire:click="approveRequest('{{ $event->id }}')" variant="primary" color="blue">
                                            Approve Coverage Request
                                        </flux:button>
                                    </div>
                                </div>



                            </div>


                        </div>

                    @endforeach
                </div>

            </div>

        @else
            {{-- Empty State --}}
            <div class="mb-5">
                <div class="flex items-center gap-2 mb-5">
                    <flux:icon.camera class="text-zinc-50" variant="solid" />
                    <flux:heading size="xl" class="font-bold whitespace-nowrap">Tsuushin Coverage</flux:heading>
                </div>

                <div class="p-5 h-full mt-8 flex flex-col justify-center items-center text-center">
                    {{-- Original SVG from empty-state component --}}
                    <svg class="w-48 mx-auto mb-4" width="178" height="90" viewBox="0 0 178 90" fill="none"
                        xmlns="http://www.w3.org/2000/svg">

                        <!-- Back cards -->
                        <rect x="27" y="50.5" width="124" height="39" rx="7.5" class="fill-white dark:fill-neutral-800" />
                        <rect x="27" y="50.5" width="124" height="39" rx="7.5"
                            class="stroke-gray-50 dark:stroke-neutral-700/10" />

                        <rect x="66.5" y="61" width="60" height="6" rx="3" class="fill-gray-50 dark:fill-neutral-700/30" />
                        <rect x="66.5" y="73" width="77" height="6" rx="3" class="fill-gray-50 dark:fill-neutral-700/30" />

                        <!-- Middle card -->
                        <rect x="19.5" y="28.5" width="139" height="39" rx="7.5" class="fill-white dark:fill-neutral-800" />
                        <rect x="19.5" y="28.5" width="139" height="39" rx="7.5"
                            class="stroke-gray-100 dark:stroke-neutral-700/30" />

                        <rect x="59" y="39" width="60" height="6" rx="3" class="fill-gray-100 dark:fill-neutral-700/70" />
                        <rect x="59" y="51" width="92" height="6" rx="3" class="fill-gray-100 dark:fill-neutral-700/70" />

                        <!-- Camera icon placeholder instead of blank rect -->
                        <g transform="translate(27,36)">
                            <rect width="24" height="24" rx="4" class="fill-gray-100 dark:fill-neutral-700/70" />
                            <circle cx="12" cy="12" r="6" class="fill-white dark:fill-neutral-800" />
                            <circle cx="12" cy="12" r="3.5" class="fill-gray-400 dark:fill-neutral-500" />
                            <rect x="6" y="5" width="5" height="2" class="fill-gray-400 dark:fill-neutral-500" />
                        </g>

                        <!-- Front/top card -->
                        <g filter="url(#manage-events-empty-state-theme)">
                            <rect x="12" y="6" width="154" height="40" rx="8" class="fill-white dark:fill-neutral-800"
                                shape-rendering="crispEdges" />
                            <rect x="12.5" y="6.5" width="153" height="39" rx="7.5"
                                class="stroke-gray-100 dark:stroke-neutral-700/60" shape-rendering="crispEdges" />

                            <!-- Camera icon front -->
                            <g transform="translate(20,14)">
                                <rect width="24" height="24" rx="4" class="fill-gray-200 dark:fill-neutral-700" />
                                <circle cx="12" cy="12" r="6" class="fill-white dark:fill-neutral-800" />
                                <circle cx="12" cy="12" r="3.5" class="fill-gray-400 dark:fill-neutral-500" />
                                <rect x="6" y="5" width="5" height="2" class="fill-gray-400 dark:fill-neutral-500" />
                            </g>

                            <rect x="52" y="17" width="60" height="6" rx="3" class="fill-gray-200 dark:fill-neutral-700" />
                            <rect x="52" y="29" width="106" height="6" rx="3" class="fill-gray-200 dark:fill-neutral-700" />
                        </g>

                        <defs>
                            <filter id="manage-events-empty-state-theme" x="0" y="0" width="178" height="64"
                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
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

                    {{-- Content --}}
                    <div class="max-w-sm mx-auto">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            No Coverage Requests
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-neutral-400 mb-4">
                            Media coverage requests will appear here.
                        </p>

                    </div>
                </div>
            </div>
        @endif

    @endif


    {{-- Header --}}
    <flux:heading size="xl" class="font-bold whitespace-nowrap">Events this <span
            class="text-[var(--color-accent)]">{{ $selectedMonth }}</span></flux:heading>



    {{-- Events for the month --}}

    @if ($events->isEmpty())

        {{-- Empty state for manage events --}}
        <div class="p-5 h-full mt-12 flex flex-col justify-center items-center text-center">
            {{-- Original SVG from empty-state component --}}
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
                <g filter="url(#manage-events-empty-state-theme)">
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
                    <filter id="manage-events-empty-state-theme" x="0" y="0" width="178" height="64"
                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
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

            {{-- Content --}}
            <div class="max-w-sm mx-auto">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    Nothing Scheduled
                </h3>
                <p class="text-sm text-gray-600 dark:text-neutral-400 mb-4">
                    You don’t have any events this <span
                        class="font-medium text-gray-900 dark:text-white">{{ now()->format('F') }}</span>.<br>
                    Stay tuned for new events!
                </p>

            </div>
        </div>

    @else

        <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-8 mt-5">

            @foreach ($events as $event)

                {{-- Event Card --}}
                <div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false"
                    class="relative z-50 w-auto h-auto">

                    {{-- Card Content --}}
                    <div @click="modalOpen=true" class="relative grid min-h-50 md:min-h-64 max-w-md sm:max-w-full flex-col items-center justify-between overflow-hidden rounded-xl bg-zinc-950
                                                                                border border-transparent hover:border-[var(--color-accent)] group transition-colors duration-300
                                                                                cursor-pointer
                                                                                ">
                        <div class="absolute inset-0 m-0 h-full w-full overflow-hidden rounded-none bg-transparent bg-cover bg-center"
                            style="background-image: url('{{ asset('storage/' . $event->image) }}');" {{--
                            style="background-image: url('https://picsum.photos/seed/{{ rand(0, 100000) }}/1080/566');" --}}>

                            <div
                                class="absolute inset-0 h-full w-full bg-gradient-to-r from-black/80 via-black/60 to-transparent">
                            </div>
                        </div>
                        <div class="relative space-y-3 p-6 px-6 py-10 md:px-12">
                            <flux:text class="font-medium text-zinc-300">
                                {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                            </flux:text>
                            <h2
                                class="text-2xl font-medium text-white leading-7 group-hover:text-[var(--color-accent)] transition-colors duration-300">
                                {{ $event->title }}
                            </h2>

                            <div class="space-y-1">
                                <div class="flex items-center gap-1">
                                    <flux:icon.clock variant="solid" class="text-zinc-300 size-4" />
                                    <flux:heading size="sm" class="text-zinc-300">
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                    </flux:heading>
                                </div>
                                <div class="flex items-center gap-1">
                                    <flux:icon.map-pin variant="solid" class="text-zinc-300 size-4" />
                                    <flux:heading size="sm" class="text-zinc-300">
                                        {{ $event->location }}
                                    </flux:heading>
                                </div>
                            </div>

                            <div class="flex items-end">

                                {{-- Tags --}}
                                @php
                                    $timezone = 'Asia/Manila';
                                    $now = \Carbon\Carbon::now()->timezone($timezone);

                                    // Combine the actual date with the time strings
                                    $start = \Carbon\Carbon::parse($event->date . ' ' . $event->start_time, $timezone);
                                    $end = \Carbon\Carbon::parse($event->date . ' ' . $event->end_time, $timezone);
                                @endphp

                                {{-- @if ($event->status == \App\Enums\EventStatus::NotFinished)
                                <flux:heading size="sm" class="flex items-center gap-2">
                                    End of Attendance: <span class="text-[var(--color-accent)] underline">{{
                                        \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}</span>
                                </flux:heading>
                                @endif --}}

                                {{-- Event status --}}
                                @if ($event->status != \App\Enums\EventStatus::Postponed)
                                    @if ($now->between($start, $end))
                                        <flux:badge color="amber" class="" variant="solid"><span class="text-black">
                                                Event In Progress</span></flux:badge>
                                    @elseif ($event->status == \App\Enums\EventStatus::NotFinished)
                                        <flux:heading size="sm" class="flex items-center gap-2">
                                            End of Attendance: <span
                                                class="text-[var(--color-accent)] underline">{{ \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}</span>
                                        </flux:heading>
                                    @endif
                                @endif

                                @if ($event->status == \App\Enums\EventStatus::Finished)
                                    <flux:badge color="green" class="" variant="solid"><span class="text-black">Event Ended</span>
                                    </flux:badge>
                                @endif

                                @if ($event->status == \App\Enums\EventStatus::Postponed)
                                    <flux:badge color="red" class="" variant="solid"><span class="text-white">Event Postponed</span>
                                    </flux:badge>
                                @endif

                            </div>
                        </div>

                    </div>

                    {{-- Modal Content --}}
                    <template x-teleport="body">
                        <div x-show="modalOpen"
                            class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak>

                            <!-- Background overlay -->
                            <div x-show="modalOpen" x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-in duration-300" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0" @click="modalOpen=false"
                                class="absolute inset-0 w-full h-full bg-opacity-10">
                            </div>

                            <!-- Modal container -->
                            <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                x-transition:leave="ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                class="relative w-full h-[80vh] sm:max-w-5xl sm:rounded-lg overflow-hidden flex">

                                <!-- Event Modal -->
                                <div class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm px-4 sm:px-0">
                                    <div class="relative w-full sm:max-w-xl max-w-md rounded-xl overflow-hidden shadow-2xl">

                                        <!-- Background Image -->
                                        <div class="relative h-96">
                                            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                                                class="absolute inset-0 w-full h-full object-cover">

                                            <!-- Close Button (kept above everything) -->
                                            <button @click="modalOpen=false"
                                                class="pointer-events-auto absolute top-4 right-4 flex items-center justify-center w-8 h-8 text-zinc-50 bg-black rounded-full hover:text-black hover:bg-zinc-50 z-20">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>

                                            <!-- Dark Overlay (allows clicks through) -->
                                            <div class="absolute inset-0 bg-black/60 pointer-events-none"></div>

                                            <!-- Centered Event Details -->
                                            <div
                                                class="relative z-10 flex flex-col items-center justify-center h-full text-center text-zinc-50 px-6 md:px-4 sm:px-0 space-y-3">
                                                <h2 class="font-bold text-2xl">{{ $event->title }}</h2>

                                                <div
                                                    class="grid grid-cols-2 space-y-3 gap-x-7 md:gap-x-5 sm:gap-x-0 whitespace-nowrap">
                                                    {{-- Date --}}
                                                    <div class="gap-2">
                                                        <div class="flex items-center justify-start gap-2">
                                                            <flux:icon.calendar variant="solid" class="text-zinc-50 size-4" />
                                                            <flux:heading size="lg">Date</flux:heading>
                                                        </div>
                                                        <div class="flex items-center justify-start gap-2">
                                                            <flux:icon.calendar class="size-4 opacity-0" />
                                                            <flux:text class="text-zinc-300">
                                                                {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                                                            </flux:text>
                                                        </div>
                                                    </div>

                                                    {{-- Time --}}
                                                    <div class="gap-2">
                                                        <div class="flex items-center justify-end gap-2">
                                                            <flux:icon.clock variant="solid" class="text-zinc-50 size-4" />
                                                            <flux:heading size="lg">Time</flux:heading>
                                                        </div>
                                                        <div class="flex items-center justify-end gap-2">
                                                            <flux:icon.calendar class="size-4 opacity-0" />
                                                            <flux:text class="text-zinc-300">
                                                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                                            </flux:text>
                                                        </div>
                                                    </div>

                                                    {{-- Location --}}
                                                    <div class="gap-2">
                                                        <div class="flex items-center justify-start gap-2">
                                                            <flux:icon.map-pin variant="solid" class="text-zinc-50 size-4" />
                                                            <flux:heading size="lg">Location</flux:heading>
                                                        </div>
                                                        <div class="flex items-center justify-start gap-2">
                                                            <flux:icon.calendar class="size-4 opacity-0" />
                                                            <flux:text class="text-zinc-300">
                                                                {{ $event->location }}
                                                            </flux:text>
                                                        </div>
                                                    </div>

                                                    {{-- Attendance End --}}
                                                    <div class="gap-2">
                                                        <div class="flex items-center justify-end gap-2">
                                                            <flux:icon.information-circle variant="solid"
                                                                class="text-zinc-50 size-4" />
                                                            <flux:heading size="lg">End of Attendance</flux:heading>
                                                        </div>
                                                        <div class="flex items-center justify-end gap-2">
                                                            <flux:icon.calendar class="size-4 opacity-0" />
                                                            <flux:text class="text-zinc-300">
                                                                <span class="text-[var(--color-accent)] underline">
                                                                    {{ \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}
                                                                </span>
                                                            </flux:text>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Attendance Status --}}
                                                <div class="gap-3">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <flux:icon.user variant="solid" class="text-zinc-50 size-4" />
                                                        <flux:heading size="lg">Your Attendance Status</flux:heading>
                                                    </div>

                                                    {{-- Badge Logic --}}
                                                    <div class="flex items-center justify-center gap-2">
                                                        <flux:icon.calendar class="size-4 opacity-0" />
                                                        @php
                                                            $log = $attendanceLogs->get($event->id);
                                                        @endphp



                                                        @if ($log)

                                                            @php
                                                                $status = $log->attendance_status?->label() ?? 'Unknown';
                                                                $color = match ($log->attendance_status) {
                                                                    \App\Enums\AttendanceStatus::Scanned => 'zinc',
                                                                    \App\Enums\AttendanceStatus::Late => 'amber',
                                                                    \App\Enums\AttendanceStatus::Present => 'green',
                                                                    default => 'red',
                                                                };

                                                                $timezone = 'Asia/Manila';
                                                                $now = now()->timezone($timezone);

                                                                // Combine date and time into Carbon instances
                                                                $start = \Carbon\Carbon::parse($event->date . ' ' . $event->start_time, $timezone);
                                                                $end = \Carbon\Carbon::parse($event->date . ' ' . $event->end_time, $timezone);
                                                            @endphp

                                                            @if ($event->status == \App\Enums\EventStatus::Finished)
                                                                <flux:badge color="{{ $color }}" variant="solid">
                                                                    {{ $status }}
                                                                </flux:badge>
                                                            @elseif($event->status == \App\Enums\EventStatus::NotFinished)
                                                                @if ($now->between($start, $end))
                                                                    <flux:badge color="amber" class="mr-10" variant="solid">
                                                                        <span class="text-black">In Progress</span>
                                                                    </flux:badge>
                                                                @else
                                                                    <flux:badge color="zinc" variant="solid">
                                                                        Upcoming
                                                                    </flux:badge>
                                                                @endif
                                                            @elseif($event->status == \App\Enums\EventStatus::Postponed)
                                                                <flux:badge color="red" variant="solid">
                                                                    <span class="text-white">Event Postponed</span>
                                                                </flux:badge>
                                                            @endif

                                                        @else
                                                            @if($event->status == \App\Enums\EventStatus::NotFinished)
                                                                @if ($now->between($start, $end))
                                                                    <flux:badge color="amber" class="mr-10" variant="solid">
                                                                        <span class="text-black">In Progress</span>
                                                                    </flux:badge>
                                                                @else
                                                                    <flux:badge color="zinc" variant="solid">
                                                                        Upcoming
                                                                    </flux:badge>
                                                                @endif
                                                            @elseif($event->status == \App\Enums\EventStatus::Postponed)
                                                                <flux:badge color="red" variant="solid">
                                                                    <span class="text-white">Event Postponed</span>
                                                                </flux:badge>
                                                            @else
                                                                {{-- <flux:badge color="zinc" variant="solid">
                                                                    No record
                                                                </flux:badge> --}}
                                                                <flux:badge color="red" variant="solid">
                                                                    Absent
                                                                </flux:badge>
                                                            @endif

                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>

                        </div>
                    </template>

                </div>

            @endforeach

        </div>

    @endif



</div>