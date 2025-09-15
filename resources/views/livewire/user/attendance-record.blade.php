<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 lg:py-10">

    <div class="max-lg:hidden flex items-center justify-between whitespace-nowrap">
        <flux:heading size="xl" class="font-bold">Attendance <span class="text-[var(--color-accent)]">Record</span>
        </flux:heading>

        <div class="flex items-center gap-2">
            @if($events->count() > 0)
                <flux:button wire:click="generateStampCard" variant="primary" color="amber" icon="arrow-down-on-square">
                    Download</flux:button>

                @if($events->count() > 1)
                    <flux:input icon="magnifying-glass" placeholder="Search Record" wire:model.live.debounce.300ms="search"
                        autocomplete="off" clearable class="" />
                @endif

            @endif
        </div>
    </div>

    {{-- Mobile view --}}
    <div class="lg:hidden whitespace-nowrap space-y-3">

        <flux:heading size="xl" class="font-bold">Attendance <span class="text-[var(--color-accent)]">Record</span>
        </flux:heading>

        {{-- Search bar --}}
        <div class="flex items-center gap-2">

            @if($events->count() > 0)

                @if($events->count() > 1)
                    <flux:input size="sm" icon="magnifying-glass" placeholder="Search Record"
                        wire:model.live.debounce.300ms="search" autocomplete="off" clearable class="" />
                @endif

                <flux:button wire:click="generateStampCard" size="sm" variant="primary" color="amber"
                    icon="arrow-down-on-square">Download</flux:button>

            @endif
        </div>
    </div>

    @if($events->isEmpty())

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

            {{-- Empty state for sanctioned students --}}
            <div class="p-5 mt-12 h-full flex flex-col justify-center items-center text-center">
                {{-- Card/ID icon illustration --}}
                <svg class="w-48 mx-auto mb-1" width="178" height="120" viewBox="0 0 178 120" fill="none"
                    xmlns="http://www.w3.org/2000/svg">

                    {{-- Background card --}}
                    <rect x="27" y="70.5" width="124" height="49" rx="7.5"
                        class="fill-white dark:fill-neutral-800 stroke-gray-50 dark:stroke-neutral-700/10"
                        stroke="currentColor" />

                    {{-- Middle card --}}
                    <rect x="19.5" y="48.5" width="139" height="49" rx="7.5"
                        class="fill-white dark:fill-neutral-800 stroke-gray-100 dark:stroke-neutral-700/30"
                        stroke="currentColor" />

                    {{-- Foreground card with shadow --}}
                    <g filter="url(#student-card-shadow)">
                        <rect x="12" y="26" width="154" height="50" rx="8"
                            class="fill-white dark:fill-neutral-800 stroke-gray-100 dark:stroke-neutral-700/60"
                            stroke="currentColor" shape-rendering="crispEdges" />

                        {{-- Card header strip --}}
                        <rect x="12" y="26" width="154" height="14" rx="8" class="fill-gray-200 dark:fill-neutral-700" />

                        {{-- Placeholder profile circle --}}
                        <circle cx="38" cy="52" r="10" class="fill-gray-300 dark:fill-neutral-600" />

                        {{-- Placeholder text lines --}}
                        <rect x="58" y="44" width="70" height="6" rx="3" class="fill-gray-200 dark:fill-neutral-700" />
                        <rect x="58" y="56" width="50" height="6" rx="3" class="fill-gray-200 dark:fill-neutral-700" />
                    </g>

                    {{-- Shadow filter definition --}}
                    <defs>
                        <filter id="student-card-shadow" x="0" y="20" width="178" height="94" filterUnits="userSpaceOnUse"
                            color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                result="hardAlpha" />
                            <feOffset dy="6" />
                            <feGaussianBlur stdDeviation="6" />
                            <feComposite in2="hardAlpha" operator="out" />
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0" />
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape" />
                        </filter>
                    </defs>
                </svg>

                {{-- Content --}}
                <div class="max-w-sm mx-auto">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        No Attendance Records
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                        Your attendance records for <span class="font-medium text-gray-900 dark:text-white">{{ $selectedSchoolYear }}</span>
                        will appear here. Stay tuned!
                    </p>
                </div>
            </div>

        @endif

    @else

        {{-- Events for the month --}}
        <div class="grid gap-3 mt-5">

            @foreach ($events as $event)

                {{-- Event Card --}}
                <div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false"
                    class="relative z-50 w-auto h-auto">

                    {{-- Card Content --}}
                    <div @click="modalOpen=true" class="relative min-h-45 md:min-h-17 lg:min-h-17 max-w-md sm:max-w-full overflow-hidden rounded-xl bg-zinc-950
                                            border border-transparent hover:border-[var(--color-accent)] group transition-colors duration-300
                                            cursor-pointer
                                            ">
                        <div class="absolute inset-0 m-0 h-full w-full overflow-hidden rounded-none bg-transparent bg-cover bg-center"
                            style="background-image: url('{{ asset('storage/' . $event->image) }}');">

                            {{-- Image and gradient conditionals --}}
                            @php
                                $log = $attendanceLogs->get($event->id);
                                $status = $log->attendance_status;
                            @endphp

                            @if ($status != \App\Enums\AttendanceStatus::Absent)
                            
                                <!-- Gradient -->
                                <div class="absolute inset-0 h-full w-full"
                                    style="background: linear-gradient(to right, rgba(0,0,0,0.5) 0%, rgba(0,0,0,1) 70%, rgba(0,0,0,1) 100%);">
                                </div>

                            @else

                                <!-- Gradient -->
                                <div
                                    class="absolute inset-0 h-full w-full bg-gradient-to-r from-black/80 via-black/60 to-transparent">
                                </div>

                            @endif

                            {{-- GJ Logo --}}
                            @if ($log)

                                @if ($status != \App\Enums\AttendanceStatus::Absent)
                                    <!-- Oversized Logo on Dark Side -->
                                    <img src="{{ asset('images/gj_logo.png') }}"
                                        class="absolute left-50 md:left-110 lg:left-140 lg:top-[-7px]  w-[50%] md:w-[20%] opacity-20 object-cover pointer-events-none select-none" />
                                    {{-- class="absolute top-[-7px] opacity-20 object-cover pointer-events-none select-none"
                                    style="left: clamp(1rem, 10vw, 35rem); width: 20%;" --}}

                                @endif
                            @endif

                        </div>

                        {{-- Content --}}
                        <div class="relative w-full space-y-1 p-6 px-6 py-5 md:px-7 sm:flex items-center justify-between">

                            <div class="">
                                <flux:text class="font-semibold text-zinc-300">
                                    {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                                </flux:text>
                                <h2
                                    class="text-xl font-medium text-white leading-7 group-hover:text-[var(--color-accent)] transition-colors duration-300">
                                    {{ $event->title }}
                                </h2>
                            </div>

                            <div class="relative mt-3 sm:mt-0 md:flex flex-col items-end justify-end h-full">
                                <flux:text class="font-semibold text-zinc-300">
                                    Your Status
                                </flux:text>

                                {{-- Badge Logic --}}
                                <div class="">
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
                                            <flux:badge color="red" variant="solid">
                                                Absent
                                            </flux:badge>
                                        @endif

                                    @endif

                                </div>
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
            @endforeach

        </div>

    @endif


</div>