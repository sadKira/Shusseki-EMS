<div>
    {{-- App Header --}}
    <div class="relative mb-10">
        {{-- Breadcrumbs --}}
        <div class="flex items-center justify-between">
            <div>
                <div class="mt-2">
                    <flux:breadcrumbs>
                        <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home
                        </flux:breadcrumbs.item>
                        <flux:breadcrumbs.item :href="route('event_timeline')" wire:navigate>Events
                        </flux:breadcrumbs.item>
                        <flux:breadcrumbs.item :href="route('event_timeline')" :accent="true" wire:navigate>
                            <span class="text-[var(--color-accent)]">Event Timeline<span>
                        </flux:breadcrumbs.item>
                    </flux:breadcrumbs>
                </div>
                <flux:heading size="xl" level="1">Event Timeline</flux:heading>
            </div>
        </div>
    </div>

    {{-- Header and search bar --}}
    <div class="max-lg:hidden flex items-center justify-between whitespace-nowrap">
        <flux:heading size="xl" class="font-bold">Academic Year <span
                class="text-[var(--color-accent)]">{{ $selectedSchoolYear }}</span></flux:heading>
        <div class="flex items-center gap-3 justify-between">
            @if($groupedEvents->count() > 0)
                <flux:button variant="filled" href="{{route('create_event')}}" icon="plus" wire:navigate>Create Event
                </flux:button>
            @endif
            @if($groupedEvents->count() > 1 || !empty($search))

                <flux:input icon="magnifying-glass" placeholder="Search Event" wire:model.live.debounce.300ms="search"
                    autocomplete="off" clearable class="" />

            @endif
        </div>
    </div>

    {{-- Calendar --}}
    <div class="mt-7">
        @if($groupedEvents->isEmpty())
            <div class="flex flex-col items-center justify-center">
                @if (!empty($search))

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
                    <x-event-empty-state :school-year="$selectedSchoolYear" />

                @endif
            </div>

        @else
            {{-- Show events timeline --}}
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
                            <div class="min-w-14 text-center">

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
                            <div class="grow pt-0.5 pb-8 relative z-50 w-auto h-auto">

                                <div class="flex flex-col items-start gap-1">
                                    {{-- <flux:button @click="modalOpen=true" variant="ghost" size="sm">
                                        <span class="font-semibold dark:text-white text-lg">
                                            {{ $event->title }}
                                        </span>

                                    </flux:button> --}}
                                    {{-- Card Content --}}
                                    <a href="{{route('view_event_timeline', $event)}}" wire:navigate class="relative min-h-17 w-full overflow-hidden rounded-xl bg-zinc-950
                                                                            border border-transparent hover:border-[var(--color-accent)] group transition-colors duration-300
                                                                            cursor-pointer
                                                                            ">
                                        <div class="absolute inset-0 m-0 h-full w-full overflow-hidden rounded-none bg-transparent bg-cover bg-center"
                                            style="background-image: url('{{ asset('storage/' . $event->image) }}');">

                                            <!-- Gradientt -->
                                            <div
                                                class="absolute inset-0 h-full w-full bg-gradient-to-r from-black/80 via-black/60 to-transparent">
                                            </div>

                                        </div>

                                        {{-- Content --}}
                                        <div class="relative w-full justify-start md:flex items-center gap-2 p-6 md:px-7">

                                            <h2
                                                class=" text-md md:text-xl font-medium text-white group-hover:text-[var(--color-accent)] transition-colors duration-300">
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
                                                    <flux:badge color="amber" class="" variant="solid"><span class="text-black">
                                                            Event In Progress</span></flux:badge>
                                                @endif
                                            @endif

                                            @if ($event->status == \App\Enums\EventStatus::Finished)
                                                <flux:badge color="green" class="" variant="solid"><span class="text-black">Event
                                                        Ended</span>
                                                </flux:badge>
                                            @endif

                                            @if ($event->status == \App\Enums\EventStatus::Postponed)
                                                <flux:badge color="red" class="" variant="solid"><span class="text-white">Event
                                                        Postponed</span>
                                                </flux:badge>
                                            @endif

                                        </div>

                                    </a>

                                </div>

                            </div>
                        </div>

                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</div>