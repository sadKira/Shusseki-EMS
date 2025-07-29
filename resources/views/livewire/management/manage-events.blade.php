<div>
    {{-- App Header --}}
    <div class=" relative mb-10 w-full">
        {{-- Breadcrumbs --}}
        <div class="flex items-center justify-between">
            <div>
                <div class="mt-2">
                    <flux:breadcrumbs>
                        <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                        <flux:breadcrumbs.item :href="route('manage_events')" wire:navigate>Events
                        </flux:breadcrumbs.item>
                        <flux:breadcrumbs.item :href="route('manage_events')" :accent="true" wire:navigate>
                            <span class="text-[var(--color-accent)]">Events Bin<span>
                        </flux:breadcrumbs.item>
                    </flux:breadcrumbs>
                </div>
                <flux:heading size="xl" level="1">Events Bin</flux:heading>
            </div>
        </div>
    </div>


    {{-- Events --}}
    <div class="grid grid-cols-5 gap-3">

        {{-- Left side --}}
        <div class="flex flex-col col-span-2 gap-3 flex-grow ">

           

            {{-- Dynamic Card --}}
    
            @if ($selectedEvent)

                <div class=" px-7 py-6 metallic-card-soft rounded-xl flex flex-col gap-5 
                           "
                   
                    >

                    {{-- Image --}}
                    <div class="">
                        <img src="{{ asset('storage/' . $selectedEvent->image) }}" alt="Event Image"
                            class="w-full h-50 object-cover shadow-md">
                    </div>

                    <div class="flex flex-col gap-2">

                        {{-- Event title --}}
                        <div class="flex items-center text-pretty gap-2">
                            <flux:heading size="xl">{{ $selectedEvent->title }}</flux:heading>

                            {{-- Title with tag --}}
                            @php
                                $timezone = 'Asia/Manila';
                                $now = \Carbon\Carbon::now()->timezone($timezone);
                                
                                // Combine the actual date with the time strings
                                $start = \Carbon\Carbon::parse($selectedEvent->date . ' ' . $selectedEvent->start_time, $timezone);
                                $end = \Carbon\Carbon::parse($selectedEvent->date . ' ' . $selectedEvent->end_time, $timezone);
                            @endphp

                            {{-- Event status --}}
                            @if ($selectedEvent->status != \App\Enums\EventStatus::Postponed)
                                @if ($now->between($start, $end))
                                    <flux:badge color="amber" class="" variant="solid"><span class="text-black">In
                                            Progress</span></flux:badge>
                                @endif
                                @if ($selectedEvent->status != \App\Enums\EventStatus::Finished)         
                                    @if ($now->gt($end))
                                        <flux:badge color="zinc" class="" variant="solid">
                                            <span class="text-white">Untracked</span>
                                        </flux:badge>
                                    @endif
                                @endif
                            @endif
                            @if ($selectedEvent->status == \App\Enums\EventStatus::Finished)
                                <flux:badge color="green" class="" variant="solid"><span
                                        class="text-black">Ended</span></flux:badge>
                            @endif
                            @if ($selectedEvent->status == \App\Enums\EventStatus::Postponed)
                                <flux:badge color="red" class="" variant="solid"><span
                                        class="text-white">Postponed</span></flux:badge>
                            @endif
                        </div>

                        {{-- Event details --}}

                        <div class="flex items-center gap-2">
                            <flux:icon.calendar class="text-zinc-50" />
                            <flux:heading>
                                {{ \Carbon\Carbon::parse($selectedEvent->date)->format('F d, Y') }}, 
                                {{ \Carbon\Carbon::parse($selectedEvent->start_time)->format('h:i A') }} - 
                                {{ \Carbon\Carbon::parse($selectedEvent->end_time)->format('h:i A') }}
                            </flux:heading>
                        </div>

                        <div class="flex items-center gap-2">
                            <flux:icon.map-pin class="text-zinc-50" />
                            <flux:heading>{{ $selectedEvent->location }}</flux:heading>
                        </div>

                        <flux:heading class="flex items-center gap-2 mt-5">
                            End of Time In Period: <span class="text-[var(--color-accent)]">{{ \Carbon\Carbon::parse($selectedEvent->time_in)->format('h:i A') }}</span>
                        </flux:heading>

                    </div>

                    <flux:button  class="w-full mt-2" variant="primary" color="amber" icon="arrow-top-right-on-square" :href="route('view_event', $selectedEvent)" wire:navigate>
                        View Event
                    </flux:button>

                    
                </div>
                
            @else
            
                {{-- Empty Image --}}
                <div class="px-7 py-6">
                    <img src="{{ asset('images/Seal_White.svg')}}" alt="Event Image"
                        class="w-full h-full object-cover shadow-md opacity-40">
                </div>

            @endif
                
                
           

        </div>


        {{-- Right side --}}
        <div class="flex flex-col col-span-3 gap-3">

            {{-- Sub Headings --}}
            <div class="whitespace-nowrap flex gap-20 items-center justify-center-safe px-7">

                {{-- Current Month --}}
                <div class="whitespace-nowrap grid justify-items-center">
                    <flux:text>Month</flux:text>            
                    <flux:heading size="xl" level="1">
                        {{ $selectedMonth }}
                    </flux:heading>
                </div>

                {{-- Events count for the Month --}}
                <div class="whitespace-nowrap grid justify-items-center">
                    <flux:text>Events this Month</flux:text>            
                    <flux:heading size="xl" level="1">
                        <div x-data="{ 
                                hoverCardHovered: false,
                                hoverCardDelay: 600,
                                hoverCardLeaveDelay: 500,
                                hoverCardTimout: null,
                                hoverCardLeaveTimeout: null,
                                hoverCardEnter () {
                                    clearTimeout(this.hoverCardLeaveTimeout);
                                    if(this.hoverCardHovered) return;
                                    clearTimeout(this.hoverCardTimout);
                                    this.hoverCardTimout = setTimeout(() => {
                                        this.hoverCardHovered = true;
                                    }, this.hoverCardDelay);
                                },
                                hoverCardLeave () {
                                    clearTimeout(this.hoverCardTimout);
                                    if(!this.hoverCardHovered) return;
                                    clearTimeout(this.hoverCardLeaveTimeout);
                                    this.hoverCardLeaveTimeout = setTimeout(() => {
                                        this.hoverCardHovered = false;
                                    }, this.hoverCardLeaveDelay);
                                }
                            }" class="relative" @mouseover="hoverCardEnter()" @mouseleave="hoverCardLeave()">
                            <a class="hover:underline">{{ $nonPostponedEventCount }}</a>
                            <div x-show="hoverCardHovered" class="absolute top-0 w-[365px] max-w-lg mt-5 z-30 -translate-x-1/2 translate-y-3 left-1/2" x-cloak>
                                <div x-show="hoverCardHovered" class="w-[full] h-auto space-x-3 p-5 flex items-start rounded-md shadow-sm metallic-card-soft" x-transition>
                                    <img src="https://cdn.devdojo.com/users/June2022/devdojo.jpg" alt="devdojo image" class="rounded-full w-14 h-14" />
                                    <div class="relative">
                                        <p class="mb-1 text-sm text-gray-600">OTEN</p>
                                        <p class="flex items-center space-x-1 text-xs text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                            </svg>
                                            <span>Joined June 2020</span>                      
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </flux:heading>
                </div>

                {{-- Postponed events count for the Month --}}
                <div class="whitespace-nowrap grid justify-items-center">
                    <flux:text>Postponed Events</flux:text>            
                    <flux:heading size="xl" level="1">
                        {{ $postponedEventCount }}
                    </flux:heading>
                </div>
                
               
            </div>

            {{-- Events for the month --}}
            <div class="px-10 py-6 rounded-xl">
                <section class="w-full flex items-center justify-between gap-2">
                    
                    {{-- <flux:button variant="ghost" href="{{route('create_event')}}" icon="plus" wire:navigate>Create Event</flux:button> --}}

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
                    <div class="flex flex-col gap-2 w-full">

                        {{-- Mini long bars --}}
                        @forelse ($events as $event)
                            <div
                                {{-- class="p-4 mr-4 flex items-center justify-between rounded-2xl dark:bg-zinc-900 dark:border-zinc-700 dark:hover:bg-zinc-800" --}}
                                {{-- class="bg-white/10 border border-white/5 shadow-inner backdrop-blur-sm p-4 mr-4 flex items-center justify-between rounded-2xl" --}}
                                {{-- class="bg-zinc-900/70 border border-white/5 shadow p-4 mr-4 flex items-center justify-between rounded-2xl" --}}
                                {{-- class="bg-gradient-to-br from-zinc-800/80 via-zinc-900/80 to-zinc-950 border border-white/5 shadow-md p-4 mr-4 flex items-center justify-between rounded-2xl" --}}
                                class="{{ $selectedEvent && $selectedEvent->id == $event->id ? 'bg-neutral-700' : 'metallic-card-soft' }} p-4 mr-4 flex items-center justify-between rounded-2xl cursor-pointer hover:bg-neutral-700 transition"
                                style="border: 2px solid rgba(255, 255, 255, 0.06);"
                                wire:click="selectEvent({{ $event->id }})"
                                >
                                <div class="flex items-center gap-3">
                                    <div>
                                        {{-- <img src="https://picsum.photos/seed/{{ rand(0, 100000) }}/40/40" alt=""
                                            class="rounded-xl"> --}}
                                        <flux:profile :chevron="false" :initials="$event->initials" avatar:color="{{ $event->avatar_color }}"/>
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

                                        // Combine date and time into Carbon instances
                                        $start = \Carbon\Carbon::parse($event->date . ' ' . $event->start_time, $timezone);
                                        $end = \Carbon\Carbon::parse($event->date . ' ' . $event->end_time, $timezone);
                                    @endphp

                                    {{-- Event status badges --}}
                                    @if ($event->status == \App\Enums\EventStatus::Finished)
                                        <flux:badge color="green" class="mr-10" variant="solid">
                                            <span class="text-black">Ended</span>
                                        </flux:badge>
                                    @elseif ($event->status == \App\Enums\EventStatus::Postponed)
                                        <flux:badge color="red" class="mr-10" variant="solid">
                                            <span class="text-white">Postponed</span>
                                        </flux:badge>
                                    @elseif ($now->between($start, $end))
                                        <flux:badge color="amber" class="mr-10" variant="solid">
                                            <span class="text-black">In Progress</span>
                                        </flux:badge>
                                    @elseif ($now->gt($end))
                                        <flux:badge color="zinc" class="mr-10" variant="solid">
                                            <span class="text-white">Untracked</span>
                                        </flux:badge>
                                    @endif

                                    {{-- <flux:button tooltip="View Event" variant="ghost" icon="arrow-top-right-on-square" :href="route('view_event', $event)" wire:navigate></flux:button> --}}
                                </div>

                            </div>
                        @empty
                            <x-empty-state />
                        @endforelse
                    </div>
                </div>
            </div>
            
        </div>

    </div>

</div>