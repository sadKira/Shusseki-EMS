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
                        <flux:breadcrumbs.item icon="ellipsis-horizontal" />
                        <flux:breadcrumbs.item :href="route('buffer_view')" :accent="true" wire:navigate>
                            <span class="text-[var(--color-accent)]">Buffer View<span>
                        </flux:breadcrumbs.item>
                    </flux:breadcrumbs>
                </div>
                <flux:heading size="xl" level="1">Buffer View</flux:heading>
            </div>
        </div>
    </div>

    <div class="p-6 bg-white rounded-xl shadow-md space-y-6" wire:ignore>
        {{-- Header --}}
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Student Attendance Records</h2>
            <span class="text-sm text-gray-500">School Year: 2024-2025</span>
        </div>

        {{-- Chart --}}
        <div class="flex flex-col md:flex-row gap-6">
            <div class="w-full md:w-1/3 flex justify-center items-center">
                <canvas id="attendancePieChart" class="max-w-[250px]"></canvas>
            </div>

            {{-- Summary Counts --}}
            <div class="w-full md:w-2/3 grid grid-cols-3 gap-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <h3 class="text-lg font-bold text-green-700">Present</h3>
                    <p class="text-2xl font-semibold text-green-900">120</p>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                    <h3 class="text-lg font-bold text-yellow-700">Late</h3>
                    <p class="text-2xl font-semibold text-yellow-900">15</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                    <h3 class="text-lg font-bold text-red-700">Absent</h3>
                    <p class="text-2xl font-semibold text-red-900">8</p>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Student Name</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Present</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Late</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Absent</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $students = [
                            ['name' => 'Juan Dela Cruz', 'present' => 20, 'late' => 2, 'absent' => 1],
                            ['name' => 'Maria Santos', 'present' => 18, 'late' => 4, 'absent' => 1],
                            ['name' => 'Pedro Reyes', 'present' => 15, 'late' => 1, 'absent' => 7],
                            ['name' => 'Ana Villanueva', 'present' => 22, 'late' => 0, 'absent' => 1],
                            ['name' => 'Mark Garcia', 'present' => 19, 'late' => 3, 'absent' => 1],
                        ];
                    @endphp

                    @foreach ($students as $student)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $student['name'] }}</td>
                            <td class="px-4 py-2 text-sm text-center text-green-700 font-medium">{{ $student['present'] }}
                            </td>
                            <td class="px-4 py-2 text-sm text-center text-yellow-700 font-medium">{{ $student['late'] }}
                            </td>
                            <td class="px-4 py-2 text-sm text-center text-red-700 font-medium">{{ $student['absent'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('attendancePieChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Present', 'Late', 'Absent'],
                    datasets: [{
                        data: [120, 15, 8], // Static data for now
                        backgroundColor: ['#22c55e', '#eab308', '#ef4444'],
                        borderColor: ['#16a34a', '#ca8a04', '#dc2626'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { size: 14 }
                            }
                        }
                    }
                }
            });
        });
    </script>









</div>