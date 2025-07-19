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

    <div class="flex gap-3">

        {{-- Date --}}
        <div class="bg-(--import) rounded-xl px-10 py-6">
            <div class="flex items-center justify-between gap-30">
                <flux:text>Date</flux:text>
                <flux:icon.calendar class="text-zinc-50" variant="mini" />
            </div>

            <div class="flex flex-col mt-5 whitespace-nowrap">
                <flux:heading size="xl" level="1">{{ \Carbon\Carbon::now()->format('F j') }}</flux:heading>
                <flux:heading size="lg" level="1">{{ \Carbon\Carbon::now()->format('l') }}</flux:heading>
            </div>
        </div>

        {{-- Total Events for the month --}}
        <div class="bg-(--import) rounded-xl px-10 py-6">
            <div class="flex items-center justify-between gap-30">
                <flux:text>Total Events</flux:text>
                <flux:icon.list-bullet class="text-zinc-50" variant="mini" />
            </div>

            <div class="flex flex-col mt-5 whitespace-nowrap">
                @if ($eventCount > 1)
                    <flux:heading size="xl" level="1">{{ $eventCount }} Events</flux:heading>
                @elseif($eventCount < 2)
                    <flux:heading size="xl" level="1">{{ $eventCount }} Event</flux:heading>
                @else
                    <flux:heading size="xl" level="1">No Events</flux:heading>
                @endif

                <flux:heading size="lg" level="1">Month of {{ \Carbon\Carbon::now()->format('F') }}</flux:heading>
            </div>
        </div>






    </div>

    <!-- Legend Indicator -->
    <div class="flex justify-center sm:justify-end items-center gap-x-4 mb-3 sm:mb-6">
        <div class="inline-flex items-center">
            <span class="size-2.5 inline-block bg-blue-600 rounded-sm me-2"></span>
            <span class="text-[13px] text-gray-600 dark:text-neutral-400">
                Income
            </span>
        </div>
        <div class="inline-flex items-center">
            <span class="size-2.5 inline-block bg-cyan-500 rounded-sm me-2"></span>
            <span class="text-[13px] text-gray-600 dark:text-neutral-400">
                Outcome
            </span>
        </div>
        <div class="inline-flex items-center">
            <span class="size-2.5 inline-block bg-gray-300 rounded-sm me-2 dark:bg-neutral-700"></span>
            <span class="text-[13px] text-gray-600 dark:text-neutral-400">
                Others
            </span>
        </div>
    </div>
    <!-- End Legend Indicator -->

    <!-- Apex Lines Chart -->
    <div id="hs-curved-line-charts"></div>

    <script src="https://preline.co/assets/js/hs-apexcharts-helpers.js"></script>

    <script>
        window.addEventListener('load', () => {
            // Apex Curved Line Charts
            (function () {
                buildChart('#hs-curved-line-charts', (mode) => ({
                    chart: {
                        height: 250,
                        type: 'line',
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        }
                    },
                    series: [
                        {
                            name: 'Income',
                            data: [0, 27000, 25000, 27000, 40000]
                        },
                        {
                            name: 'Outcome',
                            data: [19500, 10000, 19000, 17500, 26000]
                        },
                        {
                            name: 'Others',
                            data: [8000, 2200, 6000, 9000, 10000]
                        }
                    ],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: [4, 4, 4],
                        dashArray: [0, 0, 4]
                    },
                    title: {
                        show: false
                    },
                    legend: {
                        show: false
                    },
                    grid: {
                        strokeDashArray: 0,
                        borderColor: '#e5e7eb',
                        padding: {
                            top: -20,
                            right: 0
                        }
                    },
                    xaxis: {
                        type: 'category',
                        categories: [
                            '25 January 2023',
                            '28 January 2023',
                            '31 January 2023',
                            '1 February 2023',
                            '3 February 2023'
                        ],
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        tooltip: {
                            enabled: false
                        },
                        labels: {
                            offsetY: 5,
                            style: {
                                colors: '#9ca3af',
                                fontSize: '13px',
                                fontFamily: 'Inter, ui-sans-serif',
                                fontWeight: 400
                            },
                            formatter: (title) => {
                                let t = title;

                                if (t) {
                                    const newT = t.split(' ');
                                    t = `${newT[0]} ${newT[1].slice(0, 3)}`;
                                }

                                return t;
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 40000,
                        tickAmount: 4,
                        labels: {
                            align: 'left',
                            minWidth: 0,
                            maxWidth: 140,
                            style: {
                                colors: '#9ca3af',
                                fontSize: '12px',
                                fontFamily: 'Inter, ui-sans-serif',
                                fontWeight: 400
                            },
                            formatter: (value) => value >= 1000 ? `${value / 1000}k` : value
                        }
                    },
                    tooltip: {
                        custom: function (props) {
                            const { categories } = props.ctx.opts.xaxis;
                            const { dataPointIndex } = props;
                            const title = categories[dataPointIndex].split(' ');
                            const newTitle = `${title[0]} ${title[1]}`;

                            return buildTooltip(props, {
                                title: newTitle,
                                mode,
                                hasTextLabel: true,
                                wrapperExtClasses: 'min-w-36',
                                labelDivider: ':',
                                labelExtClasses: 'ms-2'
                            });
                        }
                    }
                }), {
                    colors: ['#2563EB', '#22d3ee', '#d1d5db'],
                    xaxis: {
                        labels: {
                            style: {
                                colors: '#9ca3af',
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#9ca3af'
                            }
                        }
                    },
                    grid: {
                        borderColor: '#e5e7eb'
                    }
                }, {
                    colors: ['#3b82f6', '#22d3ee', '#737373'],
                    xaxis: {
                        labels: {
                            style: {
                                colors: '#a3a3a3',
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#a3a3a3'
                            }
                        }
                    },
                    grid: {
                        borderColor: '#404040'
                    }
                });
            })();
        });
    </script>



</div>