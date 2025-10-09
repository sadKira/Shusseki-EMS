<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 lg:py-10">

    {{-- Header and search bar --}}
    <div class="max-lg:hidden flex items-center justify-between whitespace-nowrap">
        <flux:heading size="xl" class="font-bold">Event Calendar <span class="text-[var(--color-accent)]">A.Y.
                {{ $selectedSchoolYear }}</span></flux:heading>
        <div>
            @if($groupedEvents->count() > 1 || !empty($search))
                <flux:input icon="magnifying-glass" placeholder="Search Event" wire:model.live.debounce.300ms="search"
                    autocomplete="off" clearable class="" />
            @endif
        </div>
    </div>

    {{-- Mobile view --}}
    <div class="lg:hidden whitespace-nowrap space-y-3">
        <flux:heading size="xl" class="font-bold">Event Calendar <span
                class="text-[var(--color-accent)]">{{ $selectedSchoolYear }}</span></flux:heading>
        {{-- Search --}}
        <div>
            @if($groupedEvents->count() > 1 || !empty($search))
                <flux:input size="sm" icon="magnifying-glass" placeholder="Search Event"
                    wire:model.live.debounce.300ms="search" autocomplete="off" clearable class="" />
            @endif
        </div>
    </div>

    {{-- Calendar --}}
    <div class="mt-7">

        @if($groupedEvents->isEmpty())

            @if(!empty($search))

                {{-- Search empty state --}}
                <div class="p-5 h-full mt-12 flex flex-col justify-center items-center text-center">

                    <flux:icon.document-magnifying-glass class="size-14 text-gray-500" />

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        No results found
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Try adjusting your search.
                    </p>
                </div>

            @else

                {{-- Show empty state when no events exist at all --}}
                <div class="p-5 h-full mt-12 flex flex-col justify-center items-center text-center">
                    {{-- Calendar/Event icon illustration --}}
                    <svg class="w-48 mx-auto mb-4" width="178" height="120" viewBox="0 0 178 120" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        {{-- Background calendars --}}
                        <rect x="27" y="70.5" width="124" height="49" rx="7.5" fill="currentColor"
                            class="fill-white dark:fill-neutral-800" />
                        <rect x="27" y="70.5" width="124" height="49" rx="7.5" stroke="currentColor"
                            class="stroke-gray-50 dark:stroke-neutral-700/10" />
                        {{-- Calendar header --}}
                        <rect x="27" y="70.5" width="124" height="12" rx="7.5" fill="currentColor"
                            class="fill-gray-100 dark:fill-neutral-700/30" />
                        {{-- Calendar grid dots --}}
                        <circle cx="45" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />
                        <circle cx="60" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />
                        <circle cx="75" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />
                        <circle cx="90" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />
                        <circle cx="105" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />
                        <circle cx="120" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />
                        <circle cx="135" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />

                        {{-- Second calendar --}}
                        <rect x="19.5" y="48.5" width="139" height="49" rx="7.5" fill="currentColor"
                            class="fill-white dark:fill-neutral-800" />
                        <rect x="19.5" y="48.5" width="139" height="49" rx="7.5" stroke="currentColor"
                            class="stroke-gray-100 dark:stroke-neutral-700/30" />
                        {{-- Calendar header --}}
                        <rect x="19.5" y="48.5" width="139" height="12" rx="7.5" fill="currentColor"
                            class="fill-gray-100 dark:fill-neutral-700/70" />
                        {{-- Calendar grid dots --}}
                        <circle cx="37" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
                        <circle cx="52" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
                        <circle cx="67" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
                        <circle cx="82" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
                        <circle cx="97" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
                        <circle cx="112" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
                        <circle cx="127" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
                        <circle cx="142" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />

                        {{-- Main calendar with shadow --}}
                        <g filter="url(#event-empty-state-shadow)">
                            <rect x="12" y="26" width="154" height="50" rx="8" fill="currentColor"
                                class="fill-white dark:fill-neutral-800" shape-rendering="crispEdges" />
                            <rect x="12.5" y="26.5" width="153" height="49" rx="7.5" stroke="currentColor"
                                class="stroke-gray-100 dark:stroke-neutral-700/60" shape-rendering="crispEdges" />
                            {{-- Calendar header --}}
                            <rect x="12" y="26" width="154" height="14" rx="8" fill="currentColor"
                                class="fill-gray-200 dark:fill-neutral-700" />
                            {{-- Calendar binding holes --}}
                            <circle cx="35" cy="19" r="3" fill="currentColor" class="fill-gray-300 dark:fill-neutral-600" />
                            <circle cx="89" cy="19" r="3" fill="currentColor" class="fill-gray-300 dark:fill-neutral-600" />
                            <circle cx="143" cy="19" r="3" fill="currentColor" class="fill-gray-300 dark:fill-neutral-600" />
                            {{-- Calendar grid --}}
                            <circle cx="30" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="45" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="60" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="75" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="90" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="105" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="120" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="135" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="150" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />

                            <circle cx="30" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="45" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="60" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="75" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="90" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="105" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="120" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="135" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                            <circle cx="150" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
                        </g>

                        {{-- Shadow filter definition --}}
                        <defs>
                            <filter id="event-empty-state-shadow" x="0" y="20" width="178" height="94"
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
                            No Events
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-neutral-400 mb-4">
                            There are no events scheduled<br>
                            for the <span class="font-medium text-gray-900 dark:text-white">{{ $selectedSchoolYear }}</span>
                            academic
                            year.
                        </p>

                    </div>
                </div>

            @endif

        @else
            @foreach($groupedEvents as $monthYear => $events)
                <!-- Month-Year Header -->
                <h2 class="text-xl font-semibold text-white mt-5">
                    {{ \Carbon\Carbon::parse($monthYear . '-01')->format('F Y') }}
                </h2>

                <!-- Timeline -->
                <div class="mt-3">
                    @foreach($events as $event)
                        <div class="flex gap-x-3 md:gap-x-2 sm:gap-x-1">

                            <!-- Left Content (Year of the month) -->
                            <div class="md:min-w-14 min-w-8 text-center">

                                <div class="text-2xl font-bold text-white leading-none">
                                    {{ \Carbon\Carbon::parse($event->date)->format('d') }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-neutral-400">
                                    {{ \Carbon\Carbon::parse($event->date)->format('D') }}
                                </div>

                            </div>

                            <!-- Icon with vertical line -->
                            <div
                                class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-neutral-400 ">
                                <div class="relative z-10 size-7 flex justify-center items-center">
                                    <div class="size-2 rounded-full bg-neutral-400"></div>
                                </div>
                            </div>

                            <!-- Right Content (Event Title only) -->
                            <div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false"
                                class="grow pt-0.5 pb-8 relative z-50 w-auto h-auto">

                                <div class="flex flex-col items-start gap-1">
                                    {{-- <flux:button @click="modalOpen=true" variant="ghost" size="sm">
                                        <span class="font-semibold dark:text-white text-lg">
                                            {{ $event->title }}
                                        </span>

                                    </flux:button> --}}
                                    {{-- Card Content --}}
                                    <div @click="modalOpen=true" class="relative min-h-17 w-full overflow-hidden rounded-xl bg-zinc-950
                                                                    border border-transparent hover:border-[var(--color-accent)] group transition-colors duration-300
                                                                    cursor-pointer shadow-lg hover:shadow-2xl
                                                                    ">
                                        <div class="absolute inset-0 m-0 h-full w-full overflow-hidden rounded-none bg-transparent bg-cover bg-center"
                                            style="background-image: url('{{ asset('storage/' . $event->image) }}');">

                                            <!-- Gradientt -->
                                            <div
                                                class="absolute inset-0 h-full w-full bg-gradient-to-r from-black/80 via-black/60 to-transparent">
                                            </div>

                                        </div>

                                        {{-- Content --}}
                                        <div class="relative w-full justify-start md:flex items-center gap-2 p-6 md:px-7 max-w-[200px] lg:max-w-[600px]">

                                            <h2
                                                class=" text-xl font-medium truncate text-white group-hover:text-[var(--color-accent)] transition-colors duration-300">
                                                {{ $event->title }}
                                            </h2>
                                            @php
                                                $timezone = 'Asia/Manila';
                                                $now = now()->timezone($timezone);

                                                // Combine date and time into Carbon instances
                                                $start = \Carbon\Carbon::parse($event->date . ' ' . $event->start_time, $timezone);
                                                $end = \Carbon\Carbon::parse($event->date . ' ' . $event->end_time, $timezone);
                                            @endphp

                                            {{-- Event status --}}
                                            @if ($event->status != \App\Enums\EventStatus::Postponed)
                                                @if ($now->between($start, $end))
                                                    <flux:badge size="sm" color="amber" class="" variant="solid"><span class="text-black">
                                                            Event In Progress</span></flux:badge>
                                                @endif
                                            @endif

                                            @if ($event->status == \App\Enums\EventStatus::Finished)
                                                <flux:badge size="sm" color="green" class="" variant="solid"><span class="text-black">Event
                                                        Ended</span>
                                                </flux:badge>
                                            @endif

                                            @if ($event->status == \App\Enums\EventStatus::Postponed)
                                                <flux:badge size="sm" color="red" class="" variant="solid"><span class="text-white">Event
                                                        Postponed</span>
                                                </flux:badge>
                                            @endif

                                        </div>

                                    </div>

                                </div>

                                {{-- Modal Content --}}
                                <template x-teleport="body">
                                    <div x-show="modalOpen"
                                        class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen"
                                        x-cloak>

                                        <!-- Background overlay -->
                                        <div x-show="modalOpen" x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="ease-in duration-300" x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0" @click="modalOpen=false"
                                            class="absolute inset-0 w-full h-full bg-opacity-10">
                                        </div>

                                        <!-- Modal container -->
                                        <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen"
                                            x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                            x-transition:leave="ease-in duration-200"
                                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                            class="relative w-full h-[80vh] sm:max-w-5xl sm:rounded-lg overflow-hidden flex">

                                            <!-- Event Modal -->
                                            <div
                                                class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm px-4 sm:px-0">
                                                <div
                                                    class="relative w-full sm:max-w-xl max-w-md rounded-xl overflow-hidden shadow-2xl">

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
                                                        <div class="absolute inset-0 bg-black/80 pointer-events-none"></div>

                                                        <!-- Centered Event Details -->
                                                        <div
                                                            class="relative z-10 flex flex-col items-center justify-center h-full text-center text-zinc-50 px-6 md:px-4 sm:px-0 space-y-3">
                                                            <h2 class="font-bold text-2xl">{{ $event->title }}</h2>

                                                            <div
                                                                class="grid grid-cols-2 space-y-3 gap-x-7 md:gap-x-5 sm:gap-x-0 whitespace-nowrap">
                                                                {{-- Date --}}
                                                                <div class="gap-2">
                                                                    <div class="flex items-center justify-start gap-2">
                                                                        <flux:icon.calendar variant="solid"
                                                                            class="text-zinc-50 size-4" />
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
                                                                        <flux:icon.clock variant="solid"
                                                                            class="text-zinc-50 size-4" />
                                                                        <flux:heading size="lg">Time</flux:heading>
                                                                    </div>
                                                                    <div class="flex items-center justify-end gap-2">
                                                                        <flux:icon.calendar class="size-4 opacity-0" />
                                                                        <flux:text class="text-zinc-300">
                                                                            {{ \Carbon\Carbon::parse($event->start_time)->format('g:i a') }}
                                                                            -
                                                                            {{ \Carbon\Carbon::parse($event->end_time)->format('g:i a') }}
                                                                        </flux:text>
                                                                    </div>
                                                                </div>

                                                                {{-- Location --}}
                                                                <div class="gap-2">
                                                                    <div class="flex items-center justify-start gap-2">
                                                                        <flux:icon.map-pin variant="solid"
                                                                            class="text-zinc-50 size-4" />
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
                                                            <div class="gap-3 flex-col items-center justify-center">
                                                                <div class="flex items-center justify-center gap-2">
                                                                    <flux:icon.user variant="solid" class="text-zinc-50 size-4" />
                                                                    <flux:heading size="lg">Your Attendance Status</flux:heading>
                                                                </div>

                                                                {{-- Badge Logic --}}
                                                                <div class="flex items-center justify-center">
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
                                                                                <flux:badge color="amber" class="" variant="solid">
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
                                                                                <flux:badge color="amber" class="" variant="solid">
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
                        </div>

                    @endforeach
                </div>
            @endforeach
        @endif
    </div>



</div>