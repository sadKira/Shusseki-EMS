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

    {{-- Dashbord content --}}
    <div class="flex flex-col gap-3 ">

        {{-- Row 1 --}}
        <div class="grid grid-cols-4 gap-3 whitespace-nowrap">

            {{-- Date --}}
            <div class="metallic-card-soft rounded-xl px-10 py-6">
                <div class="flex items-center justify-between gap-20">
                    <flux:text>Date</flux:text>
                    <flux:icon.calendar class="text-zinc-50" variant="mini" />
                </div>

                <div class="flex flex-col mt-5 whitespace-nowrap">
                    <flux:heading size="xl" level="1">{{ \Carbon\Carbon::now()->format('F j') }}</flux:heading>
                    <flux:heading size="lg" level="1"><span
                            class="text-[var(--color-accent)]">{{ \Carbon\Carbon::now()->format('l') }}</span>
                    </flux:heading>
                </div>
            </div>

            {{-- Events in progress --}}
            <div class="metallic-card-soft rounded-xl px-10 py-6">
                <div class="flex items-center justify-between gap-20">
                    <flux:text>Ongoing</flux:text>
                    <flux:icon.arrow-down-circle class="text-zinc-50" variant="mini" />
                </div>

                <div class="flex flex-col mt-5 whitespace-nowrap">
                    @if ($todayEventCount > 1)
                        <flux:heading size="xl" level="1">{{ $todayEventCount }} Events</flux:heading>
                    @elseif($todayEventCount == 1)
                        <flux:heading size="xl" level="1">{{ $todayEventCount }} Event</flux:heading>
                    @else
                        <flux:heading size="xl" level="1">No Events</flux:heading>
                    @endif

                    <flux:heading size="lg" level="1">Happening <span class="text-[var(--color-accent)]">Today</span>
                    </flux:heading>
                </div>
            </div>

            {{-- Total Events for the week --}}
            <div class="metallic-card-soft rounded-xl px-10 py-6">
                <div class="flex items-center justify-between gap-20">
                    <flux:text>Events</flux:text>
                    <flux:icon.numbered-list class="text-zinc-50" variant="mini" />
                </div>

                <div class="flex flex-col mt-5 whitespace-nowrap">
                    @if ($weekEventCount > 1)
                        <flux:heading size="xl" level="1">{{ $weekEventCount }} Events</flux:heading>
                    @elseif($weekEventCount == 1)
                        <flux:heading size="xl" level="1">{{ $weekEventCount }} Event</flux:heading>
                    @else
                        <flux:heading size="xl" level="1">No Events</flux:heading>
                    @endif

                    <flux:heading size="lg" level="1">This <span class="text-[var(--color-accent)]">Week</span>
                    </flux:heading>
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

                    <flux:heading size="lg" level="1">Month of <span
                            class="text-[var(--color-accent)]">{{ \Carbon\Carbon::now()->format('F') }}</span>
                    </flux:heading>
                </div>
            </div>



        </div>

        {{-- Row 2 --}}
        <div class="flex items-center justify-between gap-3">

            {{-- Attendance Trends --}}

            <div class="flex items-start gap-5 metallic-card-soft px-10 py-6 rounded-xl whitespace-nowrap">
                <div class="flex flex-col">
                    <flux:text>Attendance Trend</flux:text>
                    <div class="flex items-center gap-3 mt-10">   
                        <flux:heading size="xl" level="1">{{ \Carbon\Carbon::now()->format('F') }}</flux:heading>
                        <flux:button variant="subtle" icon="chevron-down" size="sm"></flux:button>
                    </div>
                </div>

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

            {{-- Attendance Trends --}}

            <div class="metallic-card-soft px-10 py-6 rounded-xl">
                <div class="relative h-64">

                </div>
            </div>


        </div>

    </div>

    <script src="path/to/chartjs/dist/chart.umd.min.js"></script>
    {{--
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trendData = @json($attendanceTrendData);

            // Always render the chart, even if empty, to keep the card size
            new Chart(document.getElementById('monthlyAttendanceTrendChart'), {
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
                            tension: 0.4
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
                                    return trendData.eventNames && trendData.eventNames[idx]
                                        ? trendData.eventNames[idx] + ' (' + trendData.labels[idx] + ')'
                                        : trendData.labels[idx];
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
        });
    </script>

</div>