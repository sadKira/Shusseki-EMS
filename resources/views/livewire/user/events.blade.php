<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 lg:py-10">

    <div class="max-lg:hidden flex items-center justify-between whitespace-nowrap">
        <flux:heading size="xl" class="font-bold">Event calendar {{ $selectedSchoolYear }}</flux:heading>
        <div>
            <flux:input icon="magnifying-glass" placeholder="Search..." wire:model.live.debounce.300ms="search"
                autocomplete="off" clearable 
                class=""
                />
        </div>
    </div>

    {{-- Mobile view --}}
    <div class="lg:hidden whitespace-nowrap space-y-3">

        <div class="flex items-center justify-between">
            <flux:heading size="xl" class="font-bold">Event calendar {{ $selectedSchoolYear }}</flux:heading>

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
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
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
        </div>

        {{-- Search --}}
        <div>
            <flux:input icon="magnifying-glass" placeholder="Search..." wire:model.live.debounce.300ms="search"
                autocomplete="off" clearable 
                class=""
                />
        </div>
    </div>

    {{-- Calendar --}}
    <div class="mt-7">
        @foreach($groupedEvents as $monthYear => $events)
            <!-- Month-Year Header -->
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mt-5">
                {{ \Carbon\Carbon::parse($monthYear . '-01')->format('F Y') }}
            </h2>

            <!-- Timeline -->
            <div class="mt-3">
                @foreach($events as $event)
                    <div class="flex gap-x-3 md:gap-x-2 sm:gap-x-1">

                        <!-- Left Content (Year of the month) -->
                        <div class="min-w-14 text-center">
                            
                            <div class="text-2xl font-bold text-gray-800 dark:text-white leading-none">
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
                        <div 
                            x-data="{ modalOpen: false }"
                            @keydown.escape.window="modalOpen = false"
                            class="grow pt-0.5 pb-8 relative z-50 w-auto h-auto" 
                            >

                            <div class="flex flex-col items-start gap-1">
                                <flux:button @click="modalOpen=true" variant="ghost" size="sm">
                                    <span class="font-semibold dark:text-white text-lg">
                                        {{ $event->title }}
                                    </span>

                                </flux:button>
                                @php
                                    $timezone = 'Asia/Manila';
                                    $now = now()->timezone($timezone);

                                    // Combine date and time into Carbon instances
                                    $start = \Carbon\Carbon::parse($event->date . ' ' . $event->start_time, $timezone);
                                    $end = \Carbon\Carbon::parse($event->date . ' ' . $event->end_time, $timezone);
                                @endphp

                                @if ($event->status == \App\Enums\EventStatus::Postponed)
                                    <flux:badge color="red" class="ml-3" size="sm" variant="solid"><span
                                        class="text-white">Event Postponed</span></flux:badge>
                                @elseif($now->between($start, $end))
                                    <flux:badge color="amber" class="ml-3" size="sm" variant="solid">
                                        <span class="text-black">In Progress</span>
                                    </flux:badge>
                                @endif
                            </div>

                            {{-- Modal Content --}}
                            <template x-teleport="body">
                                <div x-show="modalOpen" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak>
                                    
                                    <!-- Background overlay -->
                                    <div x-show="modalOpen" 
                                        x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in duration-300"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        @click="modalOpen=false" 
                                        class="absolute inset-0 w-full h-full bg-opacity-10">
                                    </div>

                                    <!-- Modal container -->
                                    <div x-show="modalOpen"
                                        x-trap.inert.noscroll="modalOpen"
                                        x-transition:enter="ease-out duration-300"
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
                                                    <img src="{{ asset('storage/' . $event->image) }}" 
                                                        alt="Event Image"
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
                                                    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-zinc-50 px-6 md:px-4 sm:px-0 space-y-3">
                                                        <h2 class="font-bold text-2xl">{{ $event->title }}</h2>

                                                        <div class="grid grid-cols-2 space-y-3 gap-x-7 md:gap-x-5 sm:gap-x-0 whitespace-nowrap">
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
                                                                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
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
                                                                    <flux:icon.information-circle variant="solid" class="text-zinc-50 size-4" />
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
                    </div>

                @endforeach
            </div>
        @endforeach
    </div>

    

</div>