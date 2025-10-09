<div>
    {{-- App Header --}}
    <div class="flex items-center justify-between mb-10 w-full">

        {{-- Breadcrumbs --}}
        <div class="flex items-center justify-between">
            <div>
                <div class="mt-2">
                    <flux:breadcrumbs>
                        <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home
                        </flux:breadcrumbs.item>
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

        {{-- Refresh --}}
        <div wire:loading.class="opacity-100" class="opacity-0 transition-opacity duration-300">
            <flux:button icon="loading" variant="ghost">Refreshing</flux:button>
        </div>

    </div>



    {{-- Content --}}
    <div class="flex flex-col gap-3">

        {{-- Sub Headings --}}
        <div class="whitespace-nowrap flex gap-20 items-center justify-center-safe px-7"  wire:poll.15s.visible >

            {{-- Current Month --}}
            <div class="min-w-30 whitespace-nowrap grid justify-items-center">
                <flux:text>Month</flux:text>
                <flux:heading size="xl" level="1">
                    {{ $selectedMonth }}
                </flux:heading>
            </div>

            {{-- Events count for the Month --}}
            <div class="min-w-30 whitespace-nowrap grid justify-items-center">
                <flux:text>Events this Month</flux:text>
                <flux:heading size="xl" level="1">
                    {{ $nonPostponedEventCount }}
                </flux:heading>
            </div>

            {{-- Postponed events count for the Month --}}
            <div class="min-w-30 whitespace-nowrap grid justify-items-center">
                <flux:text>Postponed Events</flux:text>
                <flux:heading size="xl" level="1">
                    {{ $postponedEventCount }}
                </flux:heading>
            </div>


        </div>

        {{-- Events for the month --}}

        @if ($events->count() < 1)
            <div class="flex flex-col items-center justify-center w-full" >
                {{-- Show empty state when no events exist for the selected month --}}
                <x-manage-events-empty-state 
                    :selected-month="$selectedMonth" 
                    :selected-school-year="$selectedSchoolYear" 
                />
            </div>
        @else
            <div class="px-10 py-6 grid md:grid-cols-2 lg:grid-cols-2 gap-8 mt-5"  wire:poll.30s.visible >

                {{-- Events content --}}

                @foreach ($events as $event)
                    {{-- Event Card --}}
                    <div class="relative z-50 w-auto h-auto">

                        {{-- Card Content --}}
                        <a  href="{{route('view_event', $event)}}"
                            wire:navigate
                            class="relative grid min-h-50 md:min-h-64 max-w-md sm:max-w-full flex-col items-center justify-between overflow-hidden rounded-xl bg-zinc-950
                                        border border-transparent hover:border-[var(--color-accent)] group transition-colors duration-300
                                        cursor-pointer
                                        ">
                            <div class="absolute inset-0 m-0 h-full w-full overflow-hidden rounded-none bg-transparent bg-cover bg-center"
                                style="background-image: url('{{ asset('storage/' . $event->image) }}');">

                                <div
                                    class="absolute inset-0 h-full w-full bg-gradient-to-r from-black/80 via-black/60 to-transparent">
                                </div>
                            </div>

                            <div class="relative space-y-3 p-6 px-6 py-10 md:px-12 max-w-[400px]">
                                <flux:text class="font-medium text-zinc-300">
                                    {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                                </flux:text>
                                <h2
                                    class="text-2xl font-medium truncate text-white leading-7 group-hover:text-[var(--color-accent)] transition-colors duration-300">
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

                                    {{-- Event status --}}
                                    @if ($event->status == \App\Enums\EventStatus::Finished)
                                        <flux:badge color="green" class="" variant="solid"><span class="text-black">Event
                                                Ended</span>
                                        </flux:badge>

                                    @elseif ($event->status == \App\Enums\EventStatus::Postponed)
                                        <flux:badge color="red" class="" variant="solid"><span class="text-white">Event
                                                Postponed</span>
                                        </flux:badge>
                                    @elseif ($event->status != \App\Enums\EventStatus::Postponed)

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

                                    

                                </div>
                            </div>

                        </a>

                    </div>
                @endforeach
                
            </div>
        
        @endif

    </div>
</div>

</div>


</div>