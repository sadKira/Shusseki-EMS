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

    {{-- Main --}}
    <div class="grid grid-cols-5 gap-3">
    
        {{-- Left Side --}}
        <div class="flex flex-col col-span-3 gap-3 flex-grow">

            {{-- Stats --}}
            <div class="px-10 flex items-center justify-between">
               
                <div class="h-40 w-40" wire:ignore>
                    @if ($attendanceDoughnutData['hasEvents'])
                        <canvas id="attendanceDoughnutChart"></canvas>
                    @else
                        <p class="text-gray-500 italic">No attendance data available for this school year.</p>
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

                <div class="grid grid-cols-2 gap-1">

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
            <div class="px-10 py-6 rounded-xl">

                <flux:heading size="lg" class="mb-2">Sanctioned Students ({{ $sanctionedStudents->count() }})</flux:heading>
                {{-- Content --}}
                <div
                    class="h-60 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">
                    <div class="flex flex-col gap-2 w-full">

                        {{-- Cards --}}
                        @forelse ($sanctionedStudents as $student)
                            <a href="{{route('view_student_record', $student)}}" wire:navigate class="radial-glow-card mr-3 flex items-center justify-between p-4 rounded-xl cursor-pointer hover:bg-neutral-700 transition">
                                <div class="flex items-center gap-1">

                                    <flux:profile circle class="cursor-pointer" 
                                        avatar:name="{{ $student->name }}"
                                        avatar:color="auto"
                                        :chevron="false"
                                        {{-- color:seed="{{ auth()->user()->id }}" --}}
                                        />

                                    <div class="">
                                        <flux:text variant="strong">{{ $student->name }}</flux:text>
                                        <flux:text>ID: {{ $student->student_id }}</flux:text>
                                    </div>
                                    

                                </div>

                                <div class="flex items-end gap-2">
                                    @if ($student->late_count > 0)
                                        <flux:badge variant="solid" size="sm" color="amber">{{ $student->late_count }} Late(s)</flux:badge>
                                    @endif
                                    @if ($student->absent_count > 0)
                                        <flux:badge variant="solid" size="sm" color="red">({{ $student->absent_count }}) Absence(s)</flux:badge>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500">No sanctioned students.</p>
                        @endforelse



                    </div>

                </div>


            </div>

        </div>

        {{-- Right Side --}}
        <div class="flex flex-col col-span-2 gap-3">

            {{-- Student List --}}
            <div class="px-6 py-6 rounded-xl metallic-card-soft space-y-3">

                <flux:heading size="xl">Student List</flux:heading>
                <flux:input size="sm" icon="magnifying-glass" placeholder="Search..." wire:model.live.debounce.300ms="search"
                                autocomplete="off" clearable />

                {{-- Content --}}
                <div
                    class="h-90 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">
                    <div class="flex flex-col gap-2 w-full">

                        {{-- Cards --}}
                        @forelse ($users as $user)
                            <a href="{{route('view_student_record', $user)}}" wire:navigate class="mr-3 flex items-center justify-between p-4 rounded-xl cursor-pointer hover:bg-neutral-700 transition">
                                <div class="flex items-center gap-1">

                                    <flux:profile circle class="cursor-pointer" 
                                        avatar:name="{{ $user->name }}"
                                        avatar:color="auto"
                                        :chevron="false"
                                        {{-- color:seed="{{ auth()->user()->id }}" --}}
                                        />

                                    <div class="">
                                        <flux:text variant="strong">{{ $user->name }}</flux:text>
                                        <flux:text>ID: {{ $user->student_id }}</flux:text>
                                    </div>
                                    
                                </div>

                                <div class="flex items-end gap-2">
                                    @if ($student->late_count > 0 || $student->absent_count > 0)
                                        <flux:badge variant="solid" size="sm" color="red">Sanctioned</flux:badge>
                                    @endif
                                    {{-- @if ($student->absent_count > 0)
                                        <flux:badge variant="solid" size="sm" color="red">Sanctioned</flux:badge>
                                    @endif --}}
                                </div>
                            

                            </a>
                        @empty
                            <p class="text-gray-500">No Students</p>
                        @endforelse



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
                                    return `${label}: ${value}`;
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