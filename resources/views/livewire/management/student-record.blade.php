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
                            <flux:breadcrumbs.item :href="route('manage_students')" wire:navigate>Students
                            </flux:breadcrumbs.item>
                            <flux:breadcrumbs.item :href="route('attendance_records')" :accent="true" wire:navigate>
                                <span class="text-[var(--color-accent)]">Attendance Records<span>
                            </flux:breadcrumbs.item>
                        </flux:breadcrumbs>
                    </div>
                    <flux:heading size="xl" level="1">Attendance Records</flux:heading>
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div>

            <div wire:loading>
                <flux:button icon="loading" variant="ghost">Refreshing</flux:button>
            </div>

            <div wire:loading.remove class="flex items-center gap-3">
                @if ($this->missingAccountsCount > 0)
                    <div class="flex items-center gap-3">
                        <flux:icon.exclamation-triangle class="text-amber-500" variant="outline" />
                        <flux:button wire:click="appendMissingAccounts" icon="user-plus" variant="primary" color="amber"
                            size="sm">
                            Fill Logs - {{ $this->missingAccountsCount }}
                        </flux:button>
                    </div>
                @else
                    <flux:tooltip content="No Missing Logs to Append" position="bottom">
                        <div>
                            <flux:button wire:click="appendMissingAccounts" disabled icon="user-plus" variant="filled" 
                                size="sm">
                                No Missing Logs
                            </flux:button>
                        </div>
                    </flux:tooltip>
                @endif
            </div>
        </div>

    </div>


    {{-- Main --}}
    <div class="grid grid-cols-5 gap-3">

        {{-- Left Side --}}
        <div class="flex flex-col col-span-3 gap-3 flex-grow">

            {{-- Stats --}}
            <div class="px-10 flex items-center justify-center gap-5">

                <div class="h-40 w-40" wire:ignore>
                    @if ($attendanceDoughnutData['hasEvents'])
                        <canvas id="attendanceDoughnutChart"></canvas>
                    @else
                        {{-- Empty state for attendance doughnut chart --}}
                        <div class="flex flex-col items-center justify-center text-center">
                            {{-- Doughnut ghost illustration --}}
                            <svg class="w-40 h-40 mb-2" viewBox="0 0 120 120" fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                                {{-- Outer ghost ring --}}
                                <circle cx="60" cy="60" r="50" class="stroke-gray-300 dark:stroke-neutral-600"
                                    stroke-width="10" fill="none" />

                                {{-- Placeholder slices --}}
                                <path d="M60 10 A50 50 0 0 1 110 60" stroke="#22c55e" stroke-width="10" fill="none"
                                    stroke-dasharray="6,6" />
                                <path d="M110 60 A50 50 0 0 1 60 110" stroke="#f59e0b" stroke-width="10" fill="none"
                                    stroke-dasharray="6,6" />
                                <path d="M60 110 A50 50 0 0 1 10 60" stroke="#ef4444" stroke-width="10" fill="none"
                                    stroke-dasharray="6,6" />

                                {{-- Center text --}}
                                <text x="60" y="65" text-anchor="middle" class="fill-white text-xs font-medium">
                                    No Data
                                </text>
                            </svg>

                        </div>
                    @endif
                </div>

                {{-- Chart Legend --}}
                {{-- <div class="flex items-center gap-2">
                    <flux:badge size="sm" color="green" icon="plus">
                        {{ $attendanceDoughnutData['percentages']['present'] }}% Present
                    </flux:badge>
                    <flux:badge size="sm" color="amber" icon="exclamation-circle">
                        {{ $attendanceDoughnutData['percentages']['late'] }}% Late
                    </flux:badge>
                    <flux:badge size="sm" color="red" icon="minus">
                        {{ $attendanceDoughnutData['percentages']['absent'] }}% Absent
                    </flux:badge>
                </div> --}}

                <div class="grid grid-cols-2 gap-1" wire:poll.30s.visible>

                    <div class="px-3 py-3 whitespace-nowrap grid justify-items-start">

                        <flux:text>Present Percentage</flux:text>
                        <div class="flex items-center gap-1">
                            <flux:heading size="xl" level="1">
                                {{ $attendanceDoughnutData['percentages']['present'] }}%
                            </flux:heading>
                            <flux:icon.chevron-double-up variant="mini" class="text-green-500" />
                        </div>

                    </div>

                    <div class="px-3 py-3 whitespace-nowrap grid justify-items-start">

                        <flux:text>Late Percentage</flux:text>
                        <div class="flex items-center gap-1">
                            <flux:heading size="xl" level="1">
                                {{ $attendanceDoughnutData['percentages']['late'] }}%
                            </flux:heading>
                            <flux:icon.chevron-double-up variant="mini" class="text-amber-500" />
                        </div>

                    </div>

                    <div class="px-3 py-3 whitespace-nowrap grid justify-items-start">

                        <flux:text>Absent Percentage</flux:text>
                        <div class="flex items-center gap-1">
                            <flux:heading size="xl" level="1">
                                {{ $attendanceDoughnutData['percentages']['absent'] }}%
                            </flux:heading>
                            <flux:icon.chevron-double-down variant="mini" class="text-red-500" />
                        </div>

                    </div>

                    <div class="px-3 py-3 whitespace-nowrap grid justify-items-start">

                        <flux:text>Sanctioned Students</flux:text>
                        <flux:heading size="xl" level="1">

                            {{ $sanctionedStudents->count() }}

                        </flux:heading>

                    </div>


                </div>
            </div>

            {{-- Sanctioned Students --}}
            <div class="px-10 py-6 rounded-xl" wire:poll.30s.visible>

                @if($sanctionedStudentsCount->count() > 0)
                    <div class="flex items-center justify-between mb-3">
                        <flux:heading size="lg" class="">Sanctioned Students</flux:heading>
                        @if($sanctionedStudents->count() > 1 || !empty($sanctionedSearch) )
                            <div class="">
                                <flux:input size="sm" icon="magnifying-glass" placeholder="Search Sanctioned"
                                    wire:model.live.debounce.300ms="sanctionedSearch" autocomplete="off" clearable />
                            </div>
                        @endif
                        
                    </div>
                @endif

                {{-- Content --}}
                <div
                    class="h-60 lg:h-90 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">
                    <div class="flex flex-col gap-2 w-full">

                        @if($sanctionedStudents->isEmpty())
                            @if(!empty($sanctionedSearch))
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

                                {{-- Empty state for sanctioned students --}}
                                <div class="p-5 h-full flex flex-col justify-center items-center text-center">
                                    {{-- Card/ID icon illustration --}}
                                    <svg class="w-32 mx-auto mb-1" width="178" height="120" viewBox="0 0 178 120" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">

                                        {{-- Background card --}}
                                        <rect x="27" y="70.5" width="124" height="49" rx="7.5"
                                            class="fill-white dark:fill-neutral-800 stroke-gray-50 dark:stroke-neutral-700/10"
                                            stroke="currentColor" />

                                        {{-- Middle card --}}
                                        <rect x="19.5" y="48.5" width="139" height="49" rx="7.5"
                                            class="fill-white dark:fill-neutral-800 stroke-gray-100 dark:stroke-neutral-700/30"
                                            stroke="currentColor" />

                                        {{-- Foreground card with shadow --}}
                                        <g filter="url(#student-card-shadow)">
                                            <rect x="12" y="26" width="154" height="50" rx="8"
                                                class="fill-white dark:fill-neutral-800 stroke-gray-100 dark:stroke-neutral-700/60"
                                                stroke="currentColor" shape-rendering="crispEdges" />

                                            {{-- Card header strip --}}
                                            <rect x="12" y="26" width="154" height="14" rx="8"
                                                class="fill-gray-200 dark:fill-neutral-700" />

                                            {{-- Placeholder profile circle --}}
                                            <circle cx="38" cy="52" r="10" class="fill-gray-300 dark:fill-neutral-600" />

                                            {{-- Placeholder text lines --}}
                                            <rect x="58" y="44" width="70" height="6" rx="3"
                                                class="fill-gray-200 dark:fill-neutral-700" />
                                            <rect x="58" y="56" width="50" height="6" rx="3"
                                                class="fill-gray-200 dark:fill-neutral-700" />
                                        </g>

                                        {{-- Shadow filter definition --}}
                                        <defs>
                                            <filter id="student-card-shadow" x="0" y="20" width="178" height="94"
                                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                <feColorMatrix in="SourceAlpha" type="matrix"
                                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                                <feOffset dy="6" />
                                                <feGaussianBlur stdDeviation="6" />
                                                <feComposite in2="hardAlpha" operator="out" />
                                                <feColorMatrix type="matrix"
                                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0" />
                                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
                                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow"
                                                    result="shape" />
                                            </filter>
                                        </defs>
                                    </svg>

                                    {{-- Content --}}
                                    <div class="max-w-sm mx-auto">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                            No Sanctioned Students
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                                            There are no sanctioned students recorded<br>
                                            for the <span
                                                class="font-medium text-gray-900 dark:text-white">{{ $selectedSchoolYear }}</span>
                                            academic year.
                                        </p>
                                    </div>
                                </div>
                                
                            @endif

                        @else

                            {{-- Cards --}}
                            @foreach ($sanctionedStudents as $student)
                                <a href="{{route('view_student_record', $student)}}" wire:navigate
                                    class="radial-glow-card mr-3 flex items-center justify-between p-4 rounded-xl cursor-pointer hover:bg-neutral-700 transition">
                                    <div class="flex items-center gap-1">

                                        <flux:profile circle class="cursor-pointer" avatar:name="{{ $student->name }}"
                                            avatar:color="auto" :chevron="false" {{-- color:seed="{{ auth()->user()->id }}"
                                            --}} />

                                        <div class="max-w-[200px]">
                                            <flux:text variant="strong" class="truncate">{{ $student->name }}</flux:text>
                                            <flux:text>ID: {{ $student->student_id }}</flux:text>
                                        </div>


                                    </div>

                                    <div class="flex items-end gap-2">
                                        @if ($student->late_count > 0)
                                            <flux:badge variant="solid" size="sm" color="amber">{{ $student->late_count }} Late(s)
                                            </flux:badge>
                                        @endif
                                        @if ($student->absent_count > 0)
                                            <flux:badge variant="solid" size="sm" color="red">({{ $student->absent_count }})
                                                Absence(s)</flux:badge>
                                        @endif
                                    </div>
                                </a>
                            @endforeach

                        @endif


                    </div>

                </div>


            </div>

        </div>

        {{-- Right Side --}}
        <div class="flex flex-col col-span-2 gap-3">

            {{-- Student List --}}
            <div class="px-6 py-6 rounded-xl metallic-card-soft space-y-3" wire:poll.30s.visible>

                <flux:heading size="xl">Student List</flux:heading>
                @if($users->count() > 1 || !empty($search))
                    <flux:input size="sm" icon="magnifying-glass" placeholder="Search Student"
                        wire:model.live.debounce.300ms="search" autocomplete="off" clearable />
                @endif

                {{-- Content --}}
                <div
                    class="h-90 lg:h-125 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">
                    <div class="flex flex-col gap-2 w-full">

                        @if ($users->isEmpty())
                            @if(!empty($search))

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

                                {{-- Full empty state --}}
                                <div class="p-5 h-full flex flex-col justify-center items-center text-center">
                                    {{-- Illustration --}}
                                    <svg class="w-32 mx-auto mb-4" viewBox="0 0 160 120" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">

                                        {{-- Background sheet --}}
                                        <rect x="20" y="20" width="120" height="80" rx="8"
                                            class="fill-white dark:fill-neutral-800 stroke-gray-200 dark:stroke-neutral-700"
                                            stroke="currentColor" />

                                        {{-- Header bar --}}
                                        <rect x="20" y="20" width="120" height="16" rx="8"
                                            class="fill-gray-200 dark:fill-neutral-700" />

                                        {{-- Placeholder profile circle --}}
                                        <circle cx="50" cy="65" r="12" class="fill-gray-300 dark:fill-neutral-600" />

                                        {{-- Placeholder text lines --}}
                                        <rect x="70" y="55" width="60" height="6" rx="3"
                                            class="fill-gray-200 dark:fill-neutral-700" />
                                        <rect x="70" y="68" width="45" height="6" rx="3"
                                            class="fill-gray-200 dark:fill-neutral-700" />

                                        {{-- Bottom lines (representing list rows) --}}
                                        <rect x="35" y="90" width="90" height="6" rx="3"
                                            class="fill-gray-200 dark:fill-neutral-700" />
                                    </svg>

                                    {{-- Content --}}
                                    <div class="max-w-sm mx-auto">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                            No Students Found
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                                            Approve students to get started.
                                        </p>
                                    </div>
                                </div>

                            @endif
                        @else
                            {{-- Cards --}}
                            @foreach ($users as $user)
                                <a href="{{route('view_student_record', $user)}}" wire:navigate
                                    style="border: 2px solid rgba(255, 255, 255, 0.06);"
                                    class="mr-3 flex items-center justify-between p-4 rounded-xl cursor-pointer hover:bg-neutral-700 transition">
                                    <div class="flex items-center gap-1">

                                        <flux:profile circle class="cursor-pointer" avatar:name="{{ $user->name }}"
                                            avatar:color="auto" :chevron="false" {{-- color:seed="{{ auth()->user()->id }}"
                                            --}} />

                                        <div class="max-w-[200px]">
                                            <flux:text variant="strong" class="truncate">{{ $user->name }}</flux:text>
                                            <flux:text>ID: {{ $user->student_id }}</flux:text>
                                        </div>

                                    </div>

                                    <div class="flex items-end gap-2">

                                        @if ($user->late_count > 0 || $user->absent_count > 0)
                                            <flux:badge variant="solid" size="sm" color="red">
                                                <flux:icon.exclamation-circle variant="solid" />
                                            </flux:badge>

                                        @endif
                                      
                                    </div>


                                </a>



                            @endforeach
                        @endif



                    </div>

                </div>


            </div>

        </div>

    </div>






    {{-- Doughnut Chart --}}
    <script>
        let attendanceDoughnutChartInstance = null;

        function initAttendanceDoughnutChart() {
            const ctx = document.getElementById('attendanceDoughnutChart');
            if (!ctx) return;

            // Destroy previous chart instance if it exists
            if (attendanceDoughnutChartInstance) {
                attendanceDoughnutChartInstance.destroy();
            }

            const attendanceData = @json($attendanceDoughnutData);

            attendanceDoughnutChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: attendanceData.labels,
                    datasets: [{
                        data: attendanceData.data,
                        backgroundColor: attendanceData.colors,
                        borderColor: attendanceData.colors,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let value = context.parsed;
                                    let label = context.label || '';
                                    return `${label}: ${value}%`;
                                }
                            }
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            initAttendanceDoughnutChart();
        });

        document.addEventListener('livewire:navigated', function () {
            initAttendanceDoughnutChart();
        });

        document.addEventListener('livewire:update', function () {
            initAttendanceDoughnutChart();
        });

        document.addEventListener('school-year-updated', function () {
            initAttendanceDoughnutChart();
        });

    </script>






</div>