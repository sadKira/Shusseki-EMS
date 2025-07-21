<div>
    <div class="flex items-center justify-between mb-10 w-full">

        {{-- App Header --}}
        <div class="relative">
            {{-- Breadcrumbs --}}
            <div class="flex items-center justify-between">
                <div>
                    <div class="mt-2">
                        <flux:breadcrumbs>
                            <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home
                            </flux:breadcrumbs.item>
                            <flux:breadcrumbs.item :href="route('admin_dashboard')" :accent="true" wire:navigate>
                                <span class="text-[var(--color-accent)]">Dashboard<span>
                            </flux:breadcrumbs.item>
                        </flux:breadcrumbs>
                    </div>
                    <flux:heading size="xl" level="1">Dashboard</flux:heading>
                </div>
            </div>
        </div>

        {{-- School year --}}
        <div class="whitespace-nowrap">
            <flux:text class="text-[var(--color-accent)] flex justify-end">Academic Year</flux:text>
            <div class="flex items-center gap-2">
                <flux:icon.presentation-chart-line class="text-zinc-50" variant="solid" />
                <flux:heading size="xl" level="1">{{ $selectedSchoolYear }}</flux:heading>
            </div>
        </div>

    </div>

    <div class="flex flex-col gap-3 ">

        <div class="flex items-center gap-3 whitespace-nowrap justify-between">

            {{-- Date --}}
            <div class="metallic-card-soft rounded-xl px-10 py-6">
                <div class="flex items-center justify-between gap-20">
                    <flux:text>Date</flux:text>
                    <flux:icon.calendar class="text-zinc-50" variant="mini" />
                </div>

                <div class="flex flex-col mt-5 whitespace-nowrap">
                    <flux:heading size="xl" level="1">{{ \Carbon\Carbon::now()->format('F j') }}</flux:heading>
                    <flux:heading size="lg" level="1"><span class="text-[var(--color-accent)]">{{ \Carbon\Carbon::now()->format('l') }}</span></flux:heading>
                </div>
            </div>

            {{-- Events in progress --}}
            <div class="metallic-card-soft rounded-xl px-10 py-6">
                <div class="flex items-center justify-between gap-20">
                    <flux:text>Happening Now</flux:text>
                    <flux:icon.arrow-down-circle class="text-zinc-50" variant="mini" />
                </div>

                <div class="flex flex-col mt-5 whitespace-nowrap">
                    @if ($eventCount > 1)
                        <flux:heading size="xl" level="1">{{ $eventCount }} Events</flux:heading>
                    @elseif($eventCount == 1)
                        <flux:heading size="xl" level="1">{{ $eventCount }} Event</flux:heading>
                    @else
                        <flux:heading size="xl" level="1">No Events</flux:heading>
                    @endif

                    <flux:heading size="lg" level="1">In <span class="text-[var(--color-accent)]">Progress</span></flux:heading>
                </div>
            </div>

            {{-- Total Events for the week --}}
            <div class="metallic-card-soft rounded-xl px-10 py-6">
                <div class="flex items-center justify-between gap-20">
                    <flux:text>Events</flux:text>
                    <flux:icon.numbered-list class="text-zinc-50" variant="mini" />
                </div>

                <div class="flex flex-col mt-5 whitespace-nowrap">
                    @if ($eventCount > 1)
                        <flux:heading size="xl" level="1">{{ $eventCount }} Events</flux:heading>
                    @elseif($eventCount == 1)
                        <flux:heading size="xl" level="1">{{ $eventCount }} Event</flux:heading>
                    @else
                        <flux:heading size="xl" level="1">No Events</flux:heading>
                    @endif

                    <flux:heading size="lg" level="1">This <span class="text-[var(--color-accent)]">Week</span></flux:heading>
                </div>
            </div>

            {{-- Total Events for the month --}}
            <div class="metallic-card-soft rounded-xl px-10 py-6">
                <div class="flex items-center justify-between gap-20">
                    <flux:text>Total Events</flux:text>
                    <flux:icon.list-bullet class="text-zinc-50" variant="mini" />
                </div>

                <div class="flex flex-col mt-5 whitespace-nowrap">
                    @if ($eventCount > 1)
                        <flux:heading size="xl" level="1">{{ $eventCount }} Events</flux:heading>
                    @elseif($eventCount == 1)
                        <flux:heading size="xl" level="1">{{ $eventCount }} Event</flux:heading>
                    @else
                        <flux:heading size="xl" level="1">No Events</flux:heading>
                    @endif

                    <flux:heading size="lg" level="1">Month of <span class="text-[var(--color-accent)]">{{ \Carbon\Carbon::now()->format('F') }}</span></flux:heading>
                </div>
            </div>

            

        </div>

        <div class="flex items-center gap-3">
            
            {{-- Attendance Trends --}}
            
            
        </div>
    
    </div>

    <script src="path/to/chartjs/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    


</div>