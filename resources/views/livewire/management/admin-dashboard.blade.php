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

            {{-- Events in this school year --}}
            <div class="metallic-card-soft rounded-xl px-10 py-6">
                <div class="flex items-center justify-between gap-10">
                    <flux:text>This Academic Year</flux:text>
                    <flux:icon.arrow-down-circle class="text-zinc-50" variant="mini" />
                </div>

                <div class="flex flex-col mt-5 whitespace-nowrap">
                    @if ($nonPostponedEventCount > 1)
                        <flux:heading size="xl" level="1">{{ $nonPostponedEventCount }} Events</flux:heading>
                    @elseif($nonPostponedEventCount == 1)
                        <flux:heading size="xl" level="1">{{ $nonPostponedEventCount }} Event</flux:heading>
                    @else
                        <flux:heading size="xl" level="1">No Events</flux:heading>
                    @endif

                    <flux:heading size="lg" level="1">A.Y. <span
                            class="text-[var(--color-accent)]">{{ $selectedSchoolYear }}</span>
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
                    <flux:text>This Month</flux:text>
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
        <div class="flex items-stretch gap-3">

            {{-- Attendance Trends --}}

            <div class="flex items-start gap-7 metallic-card-soft px-10 py-6 rounded-xl whitespace-nowrap">
                <div class="flex flex-col">
                    <flux:text>Attendance Trend</flux:text>
                    <h1 class="mt-10 text-4xl">This Year</h1>
                    <flux:heading size="lg" class="text-[var(--color-accent)]"></flux:heading>

                    {{-- Chart legend --}}
                    <div class="flex flex-col gap-y-1 mt-15">
                        @php
                            $presentTotal = array_sum($attendanceTrendData['present']);
                            $lateTotal = array_sum($attendanceTrendData['late']);
                            $absentTotal = array_sum($attendanceTrendData['absent']);
                            $grandTotal = $presentTotal + $lateTotal + $absentTotal;

                            $presentPercent = $grandTotal > 0 ? round(($presentTotal / $grandTotal) * 100, 1) : 0;
                            $latePercent = $grandTotal > 0 ? round(($lateTotal / $grandTotal) * 100, 1) : 0;
                            $absentPercent = $grandTotal > 0 ? round(($absentTotal / $grandTotal) * 100, 1) : 0;
                        @endphp
                        <div class="flex items-center gap-2">
                            <svg fill="#08CB56" width="16px" height="16px" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" stroke="#08CB56">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g id="Wave_Pulse_1" data-name="Wave Pulse 1">
                                        <path
                                            d="M8.974,18h0a1.446,1.446,0,0,1-1.259-.972L5.872,12.883c-.115-.26-.262-.378-.349-.378H2.562a.5.5,0,1,1,0-1H5.523a1.444,1.444,0,0,1,1.263.972l1.839,4.145c.116.261.258.378.349.378h0c.088,0,.229-.113.344-.368L13.7,6.956A1.423,1.423,0,0,1,14.958,6h0a1.449,1.449,0,0,1,1.26.975l1.839,4.151c.11.249.259.379.349.379h3.028a.5.5,0,0,1,0,1H18.41a1.444,1.444,0,0,1-1.263-.975L15.308,7.379c-.116-.261-.259-.378-.35-.379h0c-.088,0-.229.114-.344.368l-4.385,9.676A1.437,1.437,0,0,1,8.974,18Z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <flux:text class="text-zinc-50 text-xs">Present</flux:text>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg fill="#BF1812" width="16px" height="16px" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" stroke="#BF1812">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g id="Wave_Pulse_1" data-name="Wave Pulse 1">
                                        <path
                                            d="M8.974,18h0a1.446,1.446,0,0,1-1.259-.972L5.872,12.883c-.115-.26-.262-.378-.349-.378H2.562a.5.5,0,1,1,0-1H5.523a1.444,1.444,0,0,1,1.263.972l1.839,4.145c.116.261.258.378.349.378h0c.088,0,.229-.113.344-.368L13.7,6.956A1.423,1.423,0,0,1,14.958,6h0a1.449,1.449,0,0,1,1.26.975l1.839,4.151c.11.249.259.379.349.379h3.028a.5.5,0,0,1,0,1H18.41a1.444,1.444,0,0,1-1.263-.975L15.308,7.379c-.116-.261-.259-.378-.35-.379h0c-.088,0-.229.114-.344.368l-4.385,9.676A1.437,1.437,0,0,1,8.974,18Z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <flux:text class="text-zinc-50 text-xs">Absent</flux:text>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg fill="#F59E0B" width="16px" height="16px" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" stroke="#F59E0B">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g id="Wave_Pulse_1" data-name="Wave Pulse 1">
                                        <path
                                            d="M8.974,18h0a1.446,1.446,0,0,1-1.259-.972L5.872,12.883c-.115-.26-.262-.378-.349-.378H2.562a.5.5,0,1,1,0-1H5.523a1.444,1.444,0,0,1,1.263.972l1.839,4.145c.116.261.258.378.349.378h0c.088,0,.229-.113.344-.368L13.7,6.956A1.423,1.423,0,0,1,14.958,6h0a1.449,1.449,0,0,1,1.26.975l1.839,4.151c.11.249.259.379.349.379h3.028a.5.5,0,0,1,0,1H18.41a1.444,1.444,0,0,1-1.263-.975L15.308,7.379c-.116-.261-.259-.378-.35-.379h0c-.088,0-.229.114-.344.368l-4.385,9.676A1.437,1.437,0,0,1,8.974,18Z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <flux:text class="text-zinc-50 text-xs">Late</flux:text>
                        </div>
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

            {{-- Event Status --}}
            <div class="metallic-card-soft rounded-xl px-10 py-6 whitespace-nowrap flex-grow">
                <div class="flex items-center justify-between ">
                    <flux:text>Events Overview</flux:text>
                    <flux:icon.information-circle class="text-zinc-50" variant="mini" />
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

    </div>

    <script src="path/to/chartjs/dist/chart.umd.min.js"></script>
    {{--
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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