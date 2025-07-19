<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="./assets/vendor/lodash/lodash.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
    <script src="./assets/vendor/dropzone/dist/dropzone-min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="./assets/vendor/apexcharts/dist/apexcharts.min.js"></script>
    <script src="./assets/vendor/preline/dist/helper-apexcharts.js"></script>

    <link rel="stylesheet" href="./assets/vendor/apexcharts/dist/apexcharts.css">

    @livewireStyles()

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}


</head>

<body>

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

</body>

</html>