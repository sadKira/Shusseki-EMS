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

    {{-- Dashboard content --}}
    <div class="flex flex-col gap-6 ">

        {{-- Row 1 --}}
        <div class="grid grid-cols-4 gap-6 whitespace-nowrap">

            {{-- Events in this school year --}}
            <div class="metallic-card-soft rounded-xl px-7 py-6 flex items-center justify-between">
                <div>
                    <div class="flex flex-col whitespace-nowrap">

                        @if ($nonPostponedEventCount > 1)
                            <flux:heading size="xl" level="1">{{ $nonPostponedEventCount }} Events</flux:heading>
                        @elseif($nonPostponedEventCount == 1)
                            <flux:heading size="xl" level="1">{{ $nonPostponedEventCount }} Event</flux:heading>
                        @else
                            <flux:heading size="xl" level="1">No Events</flux:heading>
                        @endif

                    </div>
                    <flux:text>This Academic Year</flux:text>
                </div>

                <flux:icon.arrow-down-circle class="size-10 text-[var(--color-accent)]" variant="outline" />
            </div>

            {{-- Attendance Rate --}}
            <div class="metallic-card-soft rounded-xl px-7 py-6 flex items-center justify-between whitespace-nowrap">
                <div>
                    <div class="flex items-center gap-1">

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

                        <flux:heading size="xl" level="1">{{ $presentPercent }}%</flux:heading>
                        {{-- <flux:icon.plus class="text-green-500" variant="micro" /> --}}

                    </div>
                    <flux:text>Attendance Rate</flux:text>
                </div>

                <flux:icon.percent-badge class="text-[var(--color-accent)] size-10" variant="outline" />
            </div>

            {{-- Total Events for the month --}}
            <flux:tooltip content="Navigate to Manage Events">
                <a href="{{ route('manage_events') }}" wire:navigate
                    class="metallic-card-soft rounded-xl px-7 py-6 flex items-center justify-between">
                    <div class="">
                        <div class="flex flex-col whitespace-nowrap">
                            @if ($eventCount > 1)
                                <flux:heading size="xl" level="1">{{ $eventCount }} Events</flux:heading>
                            @elseif($eventCount == 1)
                                <flux:heading size="xl" level="1">{{ $eventCount }} Event</flux:heading>
                            @else
                                <flux:heading size="xl" level="1">No Events</flux:heading>
                            @endif

                        </div>
                        <div class="flex items-center gap-1">
                            <flux:text>This Month</flux:text>
                            <flux:icon.arrow-top-right-on-square class="text-zinc-400" variant="micro" />
                        </div>
                    </div>

                    <flux:icon.calendar-days class="text-[var(--color-accent)] size-10" variant="outline" />
                </a>
            </flux:tooltip>

            {{-- Pending Approval --}}
            <flux:tooltip content="Navigate to Student Approval">
                <a href="{{ route('manage_approval') }}" wire:navigate
                    class="metallic-card-soft rounded-xl px-7 py-6 flex items-center justify-between">
                    <div class="">
                        <div class="flex flex-col whitespace-nowrap">
                            @if ($pendingCount > 1)
                                <flux:heading size="xl" level="1">{{ $pendingCount }} Accounts</flux:heading>
                            @elseif($pendingCount == 1)
                                <flux:heading size="xl" level="1">{{ $pendingCount }} Account</flux:heading>
                            @else
                                <flux:heading size="xl" level="1">No Pending Accounts</flux:heading>
                            @endif
                        </div>
                        <div class="flex items-center gap-1">
                            <flux:text>Pending Approval</flux:text>
                            <flux:icon.arrow-top-right-on-square class="text-zinc-400" variant="micro" />
                        </div>
                    </div>

                    <flux:icon.exclamation-circle class="text-[var(--color-accent)] size-10" variant="outline" />
                </a>
            </flux:tooltip>

        </div>

        {{-- Row 2 --}}
        <div class="flex items-stretch gap-6">

            {{-- Attendance Trends --}}
            <div class="flex flex-col gap-7 metallic-card-soft px-7 py-6 rounded-xl whitespace-nowrap">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:text>Attendance Trend</flux:text>
                        <div class="flex item-center gap-2">
                            <flux:heading size="xl" level="1" class="">{{ $selectedSchoolYear }}</flux:heading>
                            <flux:button icon="chevron-down" variant="ghost" size="sm"></flux:button>
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
                <div class="relative h-64 w-full">
                    @if($attendanceTrendData['hasEvents'])
                        <canvas id="monthlyAttendanceTrendChart" class="w-full h-full"></canvas>
                    @else
                        <canvas id="monthlyAttendanceTrendChart" class="w-full h-full"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center text-zinc-400 text-lg ">
                            No events for the month
                        </div>
                    @endif
                </div>
            </div>

            {{-- Event Status --}}
            <div class="metallic-card-soft rounded-xl px-7 py-6 whitespace-nowrap flex-grow">
                <div class="flex items-center justify-between">
                    <flux:text>Event Status Overview</flux:text>
                    {{-- <flux:icon.information-circle variant="micro" class="text-[var(--color-accent)]" /> --}}
                </div>

                {{-- Mini cards content --}}
                <div class="flex flex-col space-y-3 mt-5">

                    {{-- Finished --}}
                    <div class="relative event-status-finished p-4 rounded-xl shadow-inner">

                        {{-- svg --}}
                        <div class="absolute right-0 top-0 opacity-5 pointer-events-none">
                            <flux:icon name="check-circle" class="w-36 h-36" />
                        </div>

                        {{-- Content --}}
                        <div class="relative z-10">
                            <flux:text class="text-zinc-50">Finished</flux:text>
                            @if ($finishedCount > 1)
                                <flux:heading size="xl" level="1" class="">{{ $finishedCount }} Events</flux:heading>
                            @elseif($finishedCount == 1)
                                <flux:heading size="xl" level="1" class="">{{ $finishedCount }} Events</flux:heading>
                            @else
                                <flux:heading size="xl" level="1">No Events</flux:heading>
                            @endif
                        </div>
                    </div>

                    {{-- Postponed --}}
                    <div class="relative event-status-postponed p-4 rounded-xl shadow-inner">

                        {{-- svg --}}
                        <div class="absolute right-0 top-0 opacity-5 pointer-events-none">
                            <flux:icon name="x-circle" class="w-36 h-36" />
                        </div>

                        {{-- Content --}}
                        <div class="relative z-10">
                            <flux:text class="text-zinc-50">Postponed</flux:text>
                            @if ($postponedCount > 1)
                                <flux:heading size="xl" level="1" class="">{{ $postponedCount }} Events</flux:heading>
                            @elseif($postponedCount == 1)
                                <flux:heading size="xl" level="1" class="">{{ $postponedCount }} Events</flux:heading>
                            @else
                                <flux:heading size="xl" level="1">No Events</flux:heading>
                            @endif
                        </div>
                    </div>

                    {{-- Untracked --}}
                    <div class="relative event-status-untracked p-4 rounded-xl shadow-inner">

                        {{-- svg --}}
                        <div class="absolute right-0 top-0 opacity-5 pointer-events-none">
                            <flux:icon name="ellipsis-horizontal-circle" class="w-36 h-36" />
                        </div>

                        {{-- Content --}}
                        <div class="relative z-10">
                            <flux:text class="text-zinc-50">Untracked</flux:text>
                            @if ($untrackedCount > 1)
                                <flux:heading size="xl" level="1" class="">{{ $untrackedCount }} Events</flux:heading>
                            @elseif($untrackedCount == 1)
                                <flux:heading size="xl" level="1" class="">{{ $untrackedCount }} Events</flux:heading>
                            @else
                                <flux:heading size="xl" level="1">No Events</flux:heading>
                            @endif
                        </div>
                    </div>
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
                            borderDash:[5,5],
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

        document.addEventListener('school-year-updated', function () {
            initAttendanceTrendChart();
        });
    </script>

</div>