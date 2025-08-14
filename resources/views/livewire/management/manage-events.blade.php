<div>
    {{-- App Header --}}
    <div class=" relative mb-10 w-full">
        {{-- Breadcrumbs --}}
        <div class="flex items-center justify-between">
            <div>
                <div class="mt-2">
                    <flux:breadcrumbs>
                        <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                        <flux:breadcrumbs.item :href="route('event_timeline')" wire:navigate>Events
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

                <div class=" px-7 py-6 metallic-card-soft rounded-xl flex flex-col gap-5"
                   
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
                        {{ $nonPostponedEventCount }}                        
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
                                class="{{ $selectedEvent && $selectedEvent->id == $event->id ? 'bg-neutral-700' : 'metallic-card-soft' }} p-4 mr-4 flex items-center justify-between rounded-xl cursor-pointer hover:bg-neutral-700 transition"
                                style="border: 2px solid rgba(255, 255, 255, 0.06);"
                                wire:click="selectEvent({{ $event->id }})"
                                >
                                <div class="flex items-center gap-3">
                                    {{-- <div>
                                        <img src="https://picsum.photos/seed/{{ rand(0, 100000) }}/40/40" alt=""
                                            class="rounded-xl">
                                        <flux:profile :chevron="false" :initials="$event->initials" avatar:color="{{ $event->avatar_color }}"/>
                                    </div> --}}
                                    <div class="">
                                        <flux:text variant="strong">{{ $event->title }}</flux:text>
                                        <flux:text variant="subtle">
                                            {{ \Carbon\Carbon::parse($event->date)->format('Y, F j') }}  | 
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