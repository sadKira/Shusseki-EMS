<div class="space-y-8 p-6">

    {{-- Row 1: Key Metrics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="metallic-card-sheen flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-400">Events This Week</p>
                <p class="text-3xl font-bold text-blue-400">8</p>
            </div>
            <div class="bg-blue-100/10 p-3 rounded-full">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        <div class="metallic-card-sheen flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-400">Upcoming Events</p>
                <p class="text-3xl font-bold text-amber-400">5</p>
            </div>
            <div class="bg-amber-100/10 p-3 rounded-full">
                <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <div class="metallic-card-sheen flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-400">Students Attended</p>
                <p class="text-3xl font-bold text-green-400">127</p>
            </div>
            <div class="bg-green-100/10 p-3 rounded-full">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5V4a2 2 0 00-2-2H4a2 2 0 00-2 2v16h5m8-5a4 4 0 01-8 0" />
                </svg>
            </div>
        </div>

        <div class="metallic-card-sheen flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-400">Late Attendance</p>
                <p class="text-3xl font-bold text-red-400">12%</p>
            </div>
            <div class="bg-red-100/10 p-3 rounded-full">
                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Row 2: Upcoming Events & Recent Attendance --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="metallic-card-sheen">
            <h2 class="text-lg font-semibold mb-4 text-white">Upcoming Events</h2>
            <table class="min-w-full divide-y divide-zinc-800">
                <thead class="bg-zinc-900/50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-zinc-400 uppercase">Title</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-zinc-400 uppercase">Date</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-zinc-400 uppercase">Attendees</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    <tr>
                        <td class="px-4 py-2 text-zinc-200">Sports Festival</td>
                        <td class="px-4 py-2 text-zinc-200">Jul 25, 2025</td>
                        <td class="px-4 py-2 text-zinc-200">50</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 text-zinc-200">Cultural Night</td>
                        <td class="px-4 py-2 text-zinc-200">72</td>
                        <td class="px-4 py-2 text-zinc-200">Jul 28, 2025</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="metallic-card-sheen">
            <h2 class="text-lg font-semibold mb-4 text-white">Recent Attendance</h2>
            <ul class="divide-y divide-zinc-800">
                <li class="py-2 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-zinc-200">Jane Doe</p>
                        <p class="text-xs text-zinc-400">Sports Festival</p>
                    </div>
                    <p class="text-xs text-zinc-400">Jul 18, 09:30 AM</p>
                </li>
                <li class="py-2 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-zinc-200">John Smith</p>
                        <p class="text-xs text-zinc-400">Cultural Night</p>
                    </div>
                    <p class="text-xs text-zinc-400">Jul 17, 10:00 AM</p>
                </li>
            </ul>
        </div>
    </div>

    {{-- Row 3: Attendance Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="metallic-card-sheen">
            <h2 class="text-lg font-semibold mb-4 text-white">Attendance Breakdown</h2>
            <div class="h-64">
                <canvas id="attendanceBreakdownChart"></canvas>
            </div>
        </div>

        <div class="metallic-card-sheen">
            <h2 class="text-lg font-semibold mb-4 text-white">Weekly Attendance Trend</h2>
            <div class="h-64">
                <canvas id="attendanceTrendChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('attendanceBreakdownChart'), {
        type: 'pie',
        data: {
            labels: ['Present', 'Late', 'Scanned', 'Absent'],
            datasets: [{
                data: [80, 12, 20, 5],
                backgroundColor: ['#22c55e', '#f59e0b', '#3b82f6', '#ef4444'],
            }]
        }
    });

    new Chart(document.getElementById('attendanceTrendChart'), {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Attendance Count',
                data: [12, 19, 15, 20, 25, 30, 22],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>
