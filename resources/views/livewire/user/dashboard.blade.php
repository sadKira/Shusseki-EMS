<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 lg:py-10">

    <flux:heading size="xl" class="max-lg:hidden font-bold">Events this {{ $selectedMonth }}</flux:heading>

    {{-- Mobile view --}}
    <div class="flex items-center justify-between gap-20 lg:hidden whitespace-nowrap">
        <flux:heading size="xl" class="font-bold">Events this {{ $selectedMonth }}</flux:heading>

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

    {{-- Events for the month --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-8 mt-5">

        @foreach ($events as $event)

            {{-- Event Card --}}
            <div 

                x-data="{ modalOpen: false }"
                @keydown.escape.window="modalOpen = false"
                class="relative z-50 w-auto h-auto"
                >

                {{-- Card Content --}}
                <div 
                    @click="modalOpen=true"
                    class="relative grid min-h-64 max-w-md sm:max-w-full flex-col items-center justify-between overflow-hidden rounded-xl bg-zinc-950
                        border border-transparent hover:border-[var(--color-accent)] group transition-colors duration-300
                        ">
                    <div class="absolute inset-0 m-0 h-full w-full overflow-hidden rounded-none bg-transparent bg-cover bg-center"
                        style="background-image: url('{{ asset('storage/' . $event->image) }}');"
                        {{-- style="background-image: url('https://picsum.photos/seed/{{ rand(0, 100000) }}/1080/566');" --}}
                        >
                        
                        <div class="absolute inset-0 h-full w-full bg-gradient-to-r from-black/80 via-black/60 to-transparent">
                        </div>
                    </div>
                    <div class="relative space-y-3 p-6 px-6 py-10 md:px-12">
                        <flux:text class="font-medium text-zinc-300">
                            {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                        </flux:text>
                        <h2 class="text-2xl font-medium text-white leading-7 group-hover:text-[var(--color-accent)] transition-colors duration-300">
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
                                    End of Attendance: <span
                                        class="text-[var(--color-accent)] underline">{{ \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}</span>
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
                                <flux:badge color="green" class="" variant="solid"><span
                                        class="text-black">Event Ended</span></flux:badge>
                            @endif

                            @if ($event->status == \App\Enums\EventStatus::Postponed)
                                <flux:badge color="red" class="" variant="solid"><span
                                        class="text-white">Event Postponed</span></flux:badge>
                            @endif
                            
                        </div>
                    </div>

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
                                                            <flux:badge color="zinc" variant="solid">
                                                                No record
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



</div>