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
            {{-- <flux:text class="text-[var(--color-accent)] flex justify-end">Academic Year</flux:text>
            <div class="flex items-center gap-2">
                <flux:icon.presentation-chart-line class="text-zinc-50" variant="solid" />
                <flux:heading size="xl" level="1">{{ $selectedSchoolYear }}</flux:heading>
            </div> --}}

            <flux:button icon="calendar-date-range" variant="ghost">A.Y. {{ $selectedSchoolYear }}</flux:button>
            <flux:button onclick="setTimeout(() => window.location.href='{{ route('admin_dashboard') }}', 4000)"
                wire:click="generateYearlyReport" size="sm" icon="cloud-arrow-down" variant="primary" color="amber">
                Generate Report

            </flux:button>
        </div>

    </div>

    {{-- Dashboard content --}}
    <div class="flex flex-col gap-3 ">

        {{-- Row 1 --}}
        <div class="flex gap-3 whitespace-nowrap w-full">

            {{-- left side --}}
            <div class="grid grid-cols-2 gap-3 flex-shrink-0" style="width: 40%;">

                {{-- Events in this school year --}}
                <div class="rounded-xl px-5 py-4 flex flex-col justify-between"
                    style="border: 2px solid rgba(255, 255, 255, 0.06);"
                    >
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
                <div
                    class="rounded-xl px-5 py-4 flex flex-col justify-between whitespace-nowrap"
                    style="border: 2px solid rgba(255, 255, 255, 0.06);"
                    >
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
                        {{--
                        <flux:icon.plus class="text-green-500" variant="micro" /> --}}

                    </div>


                </div>

                {{-- Total Events for the month --}}
                <a href="{{ route('manage_events') }}" wire:navigate
                    class="rounded-xl px-5 py-4 flex flex-col justify-between"
                    style="border: 2px solid rgba(255, 255, 255, 0.06);"
                    >

                    <div class="flex items-center justify-between">
                        {{-- <flux:icon.calendar-days class="text-[var(--color-accent)] size-7" variant="outline" /> --}}
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
                <a href="{{ route('manage_approval') }}" wire:navigate
                    class="rounded-xl px-5 py-4 flex flex-col justify-between"
                    style="border: 2px solid rgba(255, 255, 255, 0.06);"
                    >
                    <div class="flex items-center justify-between">
                        {{-- <flux:icon.exclamation-circle class="text-[var(--color-accent)] size-7" variant="outline" /> --}}
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
                    <div class="relative h-44 w-full">
                        @if($attendanceTrendData['hasEvents'])
                            <canvas id="monthlyAttendanceTrendChart" class="w-full h-full"></canvas>
                        @else
                            <canvas id="monthlyAttendanceTrendChart" class="w-full h-full"></canvas>
                            <div class="absolute inset-0 flex items-center justify-center text-zinc-400 text-lg ">
                                No events
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- Row 2 --}}
        <div class="flex gap-3 whitespace-nowrap w-full">


            {{-- Event This month --}}
            <div class="vertical-glow-card vertical-glow-white rounded-xl px-5 py-4 whitespace-nowrap flex-grow"
                {{-- style="border: 2px solid rgba(255, 255, 255, 0.06);" --}}
                >
            
                {{-- <flux:text class="mb-2 text-white">Events This Month</flux:text> --}}
                 <flux:heading size="lg" class="mb-2">Events This Month</flux:heading>

                {{-- Events content --}}
                <div
                    class="h-44 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">
                    <div class="flex flex-col gap-2 w-full">

                        {{-- Mini long bars --}}
                        @forelse ($events as $event)
                            <a  href="{{route('view_event', $event)}}"
                                class=" p-4 mr-4 flex items-center justify-between rounded-xl cursor-pointer hover:bg-neutral-700 transition"
                                style="border: 2px solid rgba(255, 255, 255, 0.06);"
                                >
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
                        @empty
                            <x-empty-state />
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- right side cards --}}
            <div class="grid grid-cols-3 gap-3 flex-shrink-0" style="width: 40%;">

                {{-- Untracked Events --}}
                <div
                    class="rounded-xl px-5 py-3 flex flex-col items-center justify-center"
                    style="border: 2px solid rgba(255, 255, 255, 0.06);"
                    >
                    <flux:icon.ellipsis-horizontal-circle class="size-10 text-zinc-50" variant="outline" />
                    <flux:text class="text-xs mt-4">Untracked</flux:text>
                    @if ($untrackedCount > 1)
                        <flux:heading size="lg" level="1" class="underline">{{ $untrackedCount }} Events</flux:heading>
                    @elseif($untrackedCount == 1)
                        <flux:heading size="lg" level="1" class="underline">{{ $untrackedCount }} Event</flux:heading>
                    @else
                        <flux:heading size="lg" level="1">No Events</flux:heading>
                    @endif

                </div>

                {{-- Finished Events --}}
                <div
                    class="rounded-xl px-5 py-3 flex flex-col items-center justify-center"
                    style="border: 2px solid rgba(255, 255, 255, 0.06);"
                    >
                    <flux:icon.check-circle class="size-10 text-green-500" variant="outline" />
                    <flux:text class="text-xs mt-4">Finished</flux:text>
                    @if ($finishedCount > 1)
                        <flux:heading size="lg" level="1" class="">{{ $finishedCount }} Events</flux:heading>
                    @elseif($finishedCount == 1)
                        <flux:heading size="lg" level="1" class="">{{ $finishedCount }} Event</flux:heading>
                    @else
                        <flux:heading size="lg" level="1">No Events</flux:heading>
                    @endif

                </div>

                {{-- Postponed Events --}}
                <div
                    class="rounded-xl px-5 py-3 flex flex-col items-center justify-center"
                    style="border: 2px solid rgba(255, 255, 255, 0.06);"
                    >
                    <flux:icon.x-circle class="size-10 text-red-500" variant="outline" />
                    <flux:text class="text-xs mt-4">Postponed</flux:text>
                    @if ($postponedCount > 1)
                        <flux:heading size="lg" level="1" class="">{{ $postponedCount }} Events</flux:heading>
                    @elseif($postponedCount == 1)
                        <flux:heading size="lg" level="1" class="">{{ $postponedCount }} Event</flux:heading>
                    @else
                        <flux:heading size="lg" level="1">No Events</flux:heading>
                    @endif

                </div>

            </div>

        </div>

    </div>

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
    </script>

</div>