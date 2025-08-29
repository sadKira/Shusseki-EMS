<div>
    <div class="flex items-center justify-between mb-3 w-full">

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
        <div class="flex items-center gap-3">
            <div  wire:loading>
                <flux:button icon="loading" variant="ghost">Refreshing</flux:button>
            </div>
            <div wire:loading.remove class="flex items-center gap-3">

                <flux:button icon="calendar-date-range" variant="ghost">A.Y. {{ $selectedSchoolYear }}</flux:button>
                <flux:button x-on:click="$wire.generateYearlyReport().then(() => {
                        setTimeout(() => window.location.href='{{ route('admin_dashboard') }}', 2000);
                    })" wire:click="generateYearlyReport" size="sm" icon="cloud-arrow-down" variant="primary"
                    color="amber">

                    Generate Report

                </flux:button>
                
            </div>
        </div>

    </div>

    {{-- Dashboard content --}}
    <div class="flex flex-col gap-3 ">

        {{-- Row 1 --}}
        <div class="flex gap-3 whitespace-nowrap w-full">

            {{-- left side --}}
            <div class="grid grid-cols-2 gap-3 flex-shrink-0" style="width: 40%;" wire:poll.30s.visible>

                {{-- Events in this school year --}}
                <div class="rounded-xl px-5 py-4 flex flex-col justify-between metallic-card-soft-2nd"
                    style="border: 2px solid rgba(255, 255, 255, 0.06);">

                    <flux:icon.rectangle-group class="size-7 text-[var(--color-accent)]" variant="outline" />

                    <div class="flex flex-col whitespace-nowrap mt-3">
                        <flux:text>A.Y. {{ $selectedSchoolYear }}</flux:text>

                        @if ($nonPostponedEventCount > 1)
                            <flux:heading size="xl" level="1">{{ $nonPostponedEventCount }} Events</flux:heading>
                        @elseif($nonPostponedEventCount == 1)
                            <flux:heading size="xl" level="1">{{ $nonPostponedEventCount }} Event</flux:heading>
                        @else
                            <flux:heading size="xl" level="1">No Events</flux:heading>
                        @endif

                    </div>

                </div>

                {{-- Attendance Rate --}}
                <div class="rounded-xl px-5 py-4 flex flex-col justify-between whitespace-nowrap metallic-card-soft-2nd"
                    style="border: 2px solid rgba(255, 255, 255, 0.06);">

                    <flux:icon.percent-badge class="text-[var(--color-accent)] size-7" variant="outline" />

                    <div class="flex flex-col mt-3">

                        @php
                            $presentTotal = array_sum($attendanceTrendData['present']);
                            $lateTotal = array_sum($attendanceTrendData['late']);
                            $absentTotal = array_sum($attendanceTrendData['absent']);
                            $grandTotal = $presentTotal + $lateTotal + $absentTotal;
                            $presentFinal = $presentTotal + $lateTotal;

                            $presentPercent = $grandTotal > 0 ? round(($presentFinal / $grandTotal) * 100, 1) : 0;
                            $latePercent = $grandTotal > 0 ? round(($lateTotal / $grandTotal) * 100, 1) : 0;
                            $absentPercent = $grandTotal > 0 ? round(($absentTotal / $grandTotal) * 100, 1) : 0;
                        @endphp

                        <flux:text>Attendance Rate</flux:text>
                        <flux:heading size="xl" level="1">{{ $presentPercent }}%</flux:heading>

                    </div>


                </div>

                {{-- Total Events for the month --}}
                <a href="{{ route('manage_events') }}" wire:navigate
                    class="rounded-xl px-5 py-4 flex flex-col justify-between metallic-card-soft-2nd"
                    style="border: 2px solid rgba(255, 255, 255, 0.06);">
                    
                    <div class="flex items-start">
                        <flux:badge variant="pill" size="sm" icon:trailing="arrow-up-right">View Bin</flux:badge>
                    </div>
                    
                    <div class="flex flex-col whitespace-nowrap mt-3">
                        <flux:text>This Month</flux:text>

                        @if ($nonPostponedEventCountMonth > 1)
                            <flux:heading size="xl" level="1">{{ $nonPostponedEventCountMonth }} Events</flux:heading>
                        @elseif($nonPostponedEventCountMonth == 1)
                            <flux:heading size="xl" level="1">{{ $nonPostponedEventCountMonth }} Event</flux:heading>
                        @else
                            <flux:heading size="xl" level="1">No Events</flux:heading>
                        @endif

                    </div>

                </a>

                {{-- Pending Approval --}}
                @can('SA')

                    <a href="{{ route('manage_approval') }}" wire:navigate
                        class="rounded-xl px-5 py-4 flex flex-col justify-between metallic-card-soft-2nd"
                        style="border: 2px solid rgba(255, 255, 255, 0.06);">
                        <div class="flex items-start">
                            <flux:badge variant="pill" size="sm" icon:trailing="arrow-up-right">View Pending</flux:badge>
                        </div>
                        
                        <div class="flex flex-col whitespace-nowrap mt-3">
                            <flux:text>Pending Approval</flux:text>

                            @if ($pendingCount > 1)
                                <flux:heading size="xl" level="1">{{ $pendingCount }} Accounts</flux:heading>
                            @elseif($pendingCount == 1)
                                <flux:heading size="xl" level="1">{{ $pendingCount }} Account</flux:heading>
                            @else
                                <flux:heading size="xl" level="1">No Pending</flux:heading>
                            @endif

                        </div>
                    </a>

                @endcan
                @can('A')
                    <div class="rounded-xl px-5 py-4 flex flex-col justify-between metallic-card-soft-2nd"
                        style="border: 2px solid rgba(255, 255, 255, 0.06);">

                        <flux:icon.exclamation-circle class="text-[var(--color-accent)] size-7" variant="outline" />

                        <div class="flex flex-col whitespace-nowrap mt-3">
                            <flux:text>Pending Approval</flux:text>

                            @if ($pendingCount > 1)
                                <flux:heading size="xl" level="1">{{ $pendingCount }} Accounts</flux:heading>
                            @elseif($pendingCount == 1)
                                <flux:heading size="xl" level="1">{{ $pendingCount }} Account</flux:heading>
                            @else
                                <flux:heading size="xl" level="1">No Pending</flux:heading>
                            @endif

                        </div>
                    </div>
                @endcan
            </div>

            {{-- right side --}}
            <div class="flex-grow">

                {{-- Attendance Trends --}}
                <div
                    class="flex flex-col gap-4 vertical-glow-card vertical-glow-white px-5 py-4 rounded-xl whitespace-nowrap h-full">
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:text>Attendance Trend</flux:text>
                            <div class="flex item-center gap-2">
                                <flux:heading size="xl" level="1" class="">{{ $selectedSchoolYear }}</flux:heading>
                                {{-- <flux:button icon="chevron-down" variant="ghost" size="sm"></flux:button> --}}
                                <flux:button icon="arrow-path" variant="ghost" size="sm" tooltip="Refresh Chart" wire:click="refreshChart" />
                            </div>
                        </div>

                        {{-- Chart Legend --}}
                        @php
                            $presentTotal = array_sum($attendanceTrendData['present']);
                            $lateTotal = array_sum($attendanceTrendData['late']);
                            $absentTotal = array_sum($attendanceTrendData['absent']);
                            $grandTotal = $presentTotal + $lateTotal + $absentTotal;
                            $presentFinal = $presentTotal + $lateTotal;

                            $presentPercent = $grandTotal > 0 ? round(($presentFinal / $grandTotal) * 100, 1) : 0;
                            $latePercent = $grandTotal > 0 ? round(($lateTotal / $grandTotal) * 100, 1) : 0;
                            $absentPercent = $grandTotal > 0 ? round(($absentTotal / $grandTotal) * 100, 1) : 0;
                        @endphp

                        <div class="flex items-center gap-2">
                            <flux:badge size="sm" color="green" icon="plus">{{ $presentPercent }}% Present</flux:badge>
                            <flux:badge size="sm" color="amber" icon="exclamation-circle">{{ $latePercent }}% Late
                            </flux:badge>
                            <flux:badge size="sm" color="red" icon="minus">{{ $absentPercent }}% Absent</flux:badge>
                        </div>

                    </div>

                    {{-- Chart --}}
                    <div class="relative h-44 w-full" wire:ignore>
                        @if($attendanceTrendData['hasEvents'])
                            <canvas id="monthlyAttendanceTrendChart" class="w-full h-full"></canvas>
                        @else
                            {{-- <canvas id="monthlyAttendanceTrendChart" class="w-full h-full"></canvas> --}}
                            {{-- Show empty state when no attendance data exists --}}
                            <x-attendance-trend-empty-state :selected-school-year="$selectedSchoolYear" />
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- Row 2 --}}
        <div class="flex gap-3 whitespace-nowrap w-full">


            {{-- Event This month --}}
            <div class="vertical-glow-card vertical-glow-white rounded-xl px-5 py-4 whitespace-nowrap flex-grow" wire:poll.30s.visible {{--
                style="border: 2px solid rgba(255, 255, 255, 0.06);" --}}>

                {{-- <flux:text class="mb-2 text-white">Events This Month</flux:text> --}}
                <flux:heading size="lg" class="mb-2">Events This Month</flux:heading>


                {{-- Events content --}}
                @if ($events->count() < 1)
                    {{-- Show empty state when no events exist for the selected month --}}
                    <x-dashboard-events-empty-state :selected-month="$selectedMonth"
                        :selected-school-year="$selectedSchoolYear" />

                @else
                    <div
                        class="h-44 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">
                        <div class="flex flex-col gap-2 w-full">

                            {{-- Mini long bars --}}
                            @foreach ($events as $event)

                                <a href="{{route('view_event_timeline', $event)}}" wire:navigate
                                    class=" p-4 mr-4 flex items-center justify-between rounded-xl cursor-pointer hover:bg-neutral-700 transition"
                                    style="border: 2px solid rgba(255, 255, 255, 0.06);">
                                    <div class="flex items-center gap-3">
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

                                        {{-- <flux:button tooltip="View Event" variant="ghost" icon="arrow-top-right-on-square"
                                            :href="route('view_event', $event)" wire:navigate></flux:button> --}}
                                    </div>

                                </a>

                            @endforeach

                        </div>
                    </div>
                @endif

            </div>

            {{-- right side cards --}}
            <div class="grid grid-cols-3 gap-3 flex-shrink-0" style="width: 40%;" wire:poll.30s.visible>

                {{-- Untracked Events --}}
                <flux:modal.trigger name="view-untracked">
                    <div class="cursor-pointer rounded-xl px-5 py-3 flex flex-col items-center justify-center vertical-glow-card-2nd vertical-glow-white-2nd"
                        style="border: 2px solid rgba(255, 255, 255, 0.06);">
                        <flux:icon.ellipsis-horizontal-circle class="size-10 text-zinc-50" variant="outline" />
                        <flux:text class="text-xs mt-4">Untracked</flux:text>
                        @if ($untrackedEvents->count() > 1)
                            <flux:heading size="lg" level="1" class="underline">{{ $untrackedEvents->count() }} Events</flux:heading>
                        @elseif($untrackedEvents->count() == 1)
                            <flux:heading size="lg" level="1" class="underline">{{ $untrackedEvents->count() }} Event</flux:heading>
                        @else
                            <flux:heading size="lg" level="1">No Events</flux:heading>
                        @endif

                    </div>
                </flux:modal.trigger>

                {{-- Finished Events --}}
                <flux:modal.trigger name="view-finished">
                    <div class="cursor-pointer rounded-xl px-5 py-3 flex flex-col items-center justify-center vertical-glow-card-2nd vertical-glow-green-2nd"
                        style="border: 2px solid rgba(255, 255, 255, 0.06);">
                        <flux:icon.check-circle class="size-10 text-green-500" variant="outline" />
                        <flux:text class="text-xs mt-4">Finished</flux:text>
                        @if ($finishedEvents->count() > 1)
                            <flux:heading size="lg" level="1" class="">{{ $finishedEvents->count() }} Events</flux:heading>
                        @elseif($finishedEvents->count() == 1)
                            <flux:heading size="lg" level="1" class="">{{ $finishedEvents->count() }} Event</flux:heading>
                        @else
                            <flux:heading size="lg" level="1">No Events</flux:heading>
                        @endif

                    </div>
                </flux:modal.trigger>

                {{-- Postponed Events --}}
                <flux:modal.trigger name="view-postponed">
                    <div class="cursor-pointer rounded-xl px-5 py-3 flex flex-col items-center justify-center vertical-glow-card-2nd vertical-glow-red-2nd"
                        style="border: 2px solid rgba(255, 255, 255, 0.06);">
                        <flux:icon.x-circle class="size-10 text-red-500" variant="outline" />
                        <flux:text class="text-xs mt-4">Postponed</flux:text>
                        @if ($postponedEvents->count() > 1)
                            <flux:heading size="lg" level="1" class="">{{ $postponedEvents->count() }} Events</flux:heading>
                        @elseif($postponedEvents->count() == 1)
                            <flux:heading size="lg" level="1" class="">{{ $postponedEvents->count() }} Event</flux:heading>
                        @else
                            <flux:heading size="lg" level="1">No Events</flux:heading>
                        @endif

                    </div>
                </flux:modal.trigger>

            </div>

        </div>

    </div>

    <flux:modal name="view-untracked" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Untracked Events</flux:heading>
                <flux:text class="mt-1">Bins below must be closed as soon as possible.</flux:text>
            </div>
            @if ($untrackedEvents->count() > 0)
                <div
                    class="h-60 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">
                    <div class="flex flex-col gap-2 w-full">
                        {{-- Mini long bars --}}
                        @foreach ($untrackedEvents as $event)
                            <a href="{{route('view_event_timeline', $event)}}" wire:navigate
                                class=" p-4 mr-4 flex items-center justify-between rounded-xl cursor-pointer hover:bg-neutral-700 transition"
                                style="border: 2px solid rgba(255, 255, 255, 0.06);">
                                <div class="flex items-center gap-3">
                                    <div class="text-pretty">
                                        <flux:text variant="strong">{{ $event->title }}</flux:text>
                                        <flux:text variant="subtle">
                                            {{ \Carbon\Carbon::parse($event->date)->format('Y, F j') }}
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
                                        <flux:badge color="green" class="ml-5" variant="solid">
                                            <span class="text-black">Ended</span>
                                        </flux:badge>
                                    @elseif ($event->status == \App\Enums\EventStatus::Postponed)
                                        <flux:badge color="red" class="ml-5" variant="solid">
                                            <span class="text-white">Postponed</span>
                                        </flux:badge>
                                    @elseif ($now->between($start, $end))
                                        <flux:badge color="amber" class="ml-5" variant="solid">
                                            <span class="text-black">In Progress</span>
                                        </flux:badge>
                                    @elseif ($now->gt($end))
                                        <flux:badge color="zinc" class="ml-5" variant="solid">
                                            <span class="text-white">Untracked</span>
                                        </flux:badge>
                                    @endif

                                </div>

                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Empty state display --}}
                <div class="p-5 h-full flex flex-col justify-center items-center text-center">
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
                        <g filter="url(#empty-state-theme)">
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
                            <filter id="empty-state-theme" x="0" y="0" width="178" height="64" filterUnits="userSpaceOnUse"
                                color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                <feColorMatrix in="SourceAlpha" type="matrix"
                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                <feOffset dy="6" />
                                <feGaussianBlur stdDeviation="6" />
                                <feComposite in2="hardAlpha" operator="out" />
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0" />
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1187_14810" />
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1187_14810"
                                    result="shape" />
                            </filter>
                        </defs>
                    </svg>
                    <div class="max-w-sm mx-auto">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-neutral-400 mb-2">
                            No Untracked Events
                        </h3>
                    </div>
                </div>
            @endif
        </div>
    </flux:modal>

    <flux:modal name="view-finished" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Finished Events</flux:heading>
                <flux:text class="mt-1">Finished events with closed bins.</flux:text>
            </div>
            @if ($finishedEvents->count() > 0)
                <div
                    class="h-60 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">
                    <div class="flex flex-col gap-2 w-full">
                        {{-- Mini long bars --}}
                        @foreach ($finishedEvents as $event)
                            <a href="{{route('view_event_timeline', $event)}}" wire:navigate
                                class=" p-4 mr-4 flex items-center justify-between rounded-xl cursor-pointer hover:bg-neutral-700 transition"
                                style="border: 2px solid rgba(255, 255, 255, 0.06);">
                                <div class="flex items-center gap-3">
                                    <div class="text-pretty">
                                        <flux:text variant="strong">{{ $event->title }}</flux:text>
                                        <flux:text variant="subtle">
                                            {{ \Carbon\Carbon::parse($event->date)->format('Y, F j') }}
                                        </flux:text>
                                    </div>
                                </div>
                                <div class="flex items-center">

                                    @php
                                        $timezone = 'Asia/Manila';
                                        $now = now()->timezone($timezone);

                                        // Combine date and time into Carbon instances
                                        $start = \Carbon\Carbon::parse($event->date . ' ' . $event->start_time, $timezone);
                                        $end = \Carbon\Carbon::parse($event->date . ' ' . $event->end_time, $timezone);
                                    @endphp

                                    {{-- Event status badges --}}
                                    @if ($event->status == \App\Enums\EventStatus::Finished)
                                        <flux:badge color="green" class="ml-5" variant="solid">
                                            <span class="text-black">Ended</span>
                                        </flux:badge>
                                    @elseif ($event->status == \App\Enums\EventStatus::Postponed)
                                        <flux:badge color="red" class="ml-5" variant="solid">
                                            <span class="text-white">Postponed</span>
                                        </flux:badge>
                                    @elseif ($now->between($start, $end))
                                        <flux:badge color="amber" class="ml-5" variant="solid">
                                            <span class="text-black">In Progress</span>
                                        </flux:badge>
                                    @elseif ($now->gt($end))
                                        <flux:badge color="zinc" class="ml-5" variant="solid">
                                            <span class="text-white">Untracked</span>
                                        </flux:badge>
                                    @endif

                                </div>

                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Empty state display --}}
                <div class="p-5 h-full flex flex-col justify-center items-center text-center">
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
                        <g filter="url(#empty-state-theme)">
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
                            <filter id="empty-state-theme" x="0" y="0" width="178" height="64" filterUnits="userSpaceOnUse"
                                color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                <feColorMatrix in="SourceAlpha" type="matrix"
                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                <feOffset dy="6" />
                                <feGaussianBlur stdDeviation="6" />
                                <feComposite in2="hardAlpha" operator="out" />
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0" />
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1187_14810" />
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1187_14810"
                                    result="shape" />
                            </filter>
                        </defs>
                    </svg>
                    <div class="max-w-sm mx-auto">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-neutral-400 mb-2">
                            No Finished Events
                        </h3>
                    </div>
                </div>
            @endif
        </div>
    </flux:modal>

    <flux:modal name="view-postponed" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Postponed Events</flux:heading>
                <flux:text class="mt-1">List of postponed events.</flux:text>
            </div>
            @if ($postponedEvents->count() > 0)
                <div
                    class="h-60 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">
                    <div class="flex flex-col gap-2 w-full">
                        {{-- Mini long bars --}}
                        @foreach ($postponedEvents as $event)
                            <a href="{{route('view_event_timeline', $event)}}" wire:navigate
                                class=" p-4 mr-4 flex items-center justify-between rounded-xl cursor-pointer hover:bg-neutral-700 transition"
                                style="border: 2px solid rgba(255, 255, 255, 0.06);">
                                <div class="flex items-center gap-3">
                                    <div class="text-pretty">
                                        <flux:text variant="strong">{{ $event->title }}</flux:text>
                                        <flux:text variant="subtle">
                                            {{ \Carbon\Carbon::parse($event->date)->format('Y, F j') }}
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
                                        <flux:badge color="green" class="ml-5" variant="solid">
                                            <span class="text-black">Ended</span>
                                        </flux:badge>
                                    @elseif ($event->status == \App\Enums\EventStatus::Postponed)
                                        <flux:badge color="red" class="ml-5" variant="solid">
                                            <span class="text-white">Postponed</span>
                                        </flux:badge>
                                    @elseif ($now->between($start, $end))
                                        <flux:badge color="amber" class="ml-5" variant="solid">
                                            <span class="text-black">In Progress</span>
                                        </flux:badge>
                                    @elseif ($now->gt($end))
                                        <flux:badge color="zinc" class="ml-5" variant="solid">
                                            <span class="text-white">Untracked</span>
                                        </flux:badge>
                                    @endif

                                </div>

                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Empty state display --}}
                <div class="p-5 h-full flex flex-col justify-center items-center text-center">
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
                        <g filter="url(#empty-state-theme)">
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
                            <filter id="empty-state-theme" x="0" y="0" width="178" height="64" filterUnits="userSpaceOnUse"
                                color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                <feColorMatrix in="SourceAlpha" type="matrix"
                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                <feOffset dy="6" />
                                <feGaussianBlur stdDeviation="6" />
                                <feComposite in2="hardAlpha" operator="out" />
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0" />
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1187_14810" />
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1187_14810"
                                    result="shape" />
                            </filter>
                        </defs>
                    </svg>
                    <div class="max-w-sm mx-auto">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-neutral-400 mb-2">
                            No Postponed Events
                        </h3>
                    </div>
                </div>
            @endif
        </div>
    </flux:modal>

    {{-- Redirect user after pdf export --}}
    <script>
        Livewire.on('reportExported', () => {
            setTimeout(() => {
                window.location.href = "{{ route('admin_dashboard') }}";
            }, 2000); // adjust delay as needed
        });
    </script>

    <script>
        let attendanceTrendChartInstance = null;

        function initAttendanceTrendChart() {
            const ctx = document.getElementById('monthlyAttendanceTrendChart');
            if (!ctx) return;

            // Destroy previous chart instance if it exists
            if (attendanceTrendChartInstance) {
                attendanceTrendChartInstance.destroy();
            }

            const trendData = @json($attendanceTrendData);
            // Add year info for each label (reconstruct from monthYearPairs if needed)
            // For this, we need to pass the years for each label from PHP
            // We'll assume you add 'years' to the trendData array in PHP:
            // 'years' => $years,

            // Create labels with year (e.g., "Jul '25")
            const labels = trendData.labels.map((month, index) => {
                const year = trendData.years ? trendData.years[index] : new Date().getFullYear();
                return `${month} '${year.toString().slice(-2)}`; // Shows "Jul '25" format
            });

            attendanceTrendChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: trendData.labels,
                    datasets: [
                        {
                            label: 'Present',
                            data: trendData.present,
                            borderColor: '#22c55e',
                            backgroundColor: 'rgba(34,197,94,0.1)',
                            fill: false,
                            tension: 0.4
                        },
                        {
                            label: 'Late',
                            data: trendData.late,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245,158,11,0.1)',
                            fill: false,
                            tension: 0.4,
                            borderDash: [5, 5],
                            borderWidth: 2

                        },
                        {
                            label: 'Absent',
                            data: trendData.absent,
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239,68,68,0.1)',
                            fill: false,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                title: function (context) {
                                    const idx = context[0].dataIndex;
                                    // Show event name, month, and year if available
                                    let label = trendData.labels[idx];
                                    let year = trendData.years ? trendData.years[idx] : '';
                                    if (trendData.eventNames && trendData.eventNames[idx]) {
                                        return trendData.eventNames[idx] + ' (' + label + (year ? ' ' + year : '') + ')';
                                    } else {
                                        return label + (year ? ' ' + year : '');
                                    }
                                },
                                label: function (context) {
                                    return context.dataset.label + ': ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            initAttendanceTrendChart();
        });

        document.addEventListener('livewire:navigated', function () {
            initAttendanceTrendChart();
        });

        document.addEventListener('livewire:update', function () {
            initAttendanceTrendChart();
        });

        document.addEventListener('school-year-updated', function () {
            initAttendanceTrendChart();
        });

        document.addEventListener('chart-data-updated', function(event) {
            // Update the chart with new data
            const newData = event.detail.data;
            
            if (attendanceTrendChartInstance) {
                // Update the chart data
                attendanceTrendChartInstance.data.labels = newData.labels;
                attendanceTrendChartInstance.data.datasets[0].data = newData.present;
                attendanceTrendChartInstance.data.datasets[1].data = newData.late;
                attendanceTrendChartInstance.data.datasets[2].data = newData.absent;
                
                // Redraw the chart
                attendanceTrendChartInstance.update();
            }

        });

    </script>

</div>