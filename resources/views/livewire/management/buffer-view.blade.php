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

    <div class="max-w-5xl mx-auto p-6 space-y-6">
        {{-- Page Title --}}
        <div class="flex items-center justify-between">
            <flux:heading size="xl" class="text-white">📄 Generate Report</flux:heading>
        </div>

        {{-- Card --}}
        <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 shadow-lg space-y-6">
            {{-- Description --}}
            <p class="text-sm text-zinc-400">
                Configure your report settings. You can generate a report for the entire school year or filter it to a specific month.
            </p>

            {{-- School Year Select --}}
            <div class="space-y-1">
                <flux:label for="school_year">School Year</flux:label>
                <flux:select id="school_year" wire:model="selectedSchoolYear" class="w-full">
                    <option value="">Select School Year</option>
                    <option value="2024-2025">2024-2025</option>
                    <option value="2023-2024">2023-2024</option>
                    <option value="2022-2023">2022-2023</option>
                </flux:select>
            </div>

            {{-- Month Select --}}
            <div class="space-y-1">
                <flux:label for="month">Month (Optional)</flux:label>
                <flux:select id="month" wire:model="selectedMonth" class="w-full">
                    <option value="">All Months</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </flux:select>
            </div>

            {{-- Buttons --}}
            <div class="flex space-x-3 pt-4">
                <flux:button color="primary" wire:click="generateReport">
                    Generate Report
                </flux:button>

                <flux:button color="secondary" wire:click="resetFilters">
                    Reset
                </flux:button>
            </div>
        </div>

        {{-- Example Table for Preview (Static Data) --}}
        <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 shadow-lg">
            <flux:heading size="md" class="mb-4 text-white">Preview</flux:heading>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs uppercase bg-zinc-800 text-gray-300">
                        <tr>
                            <th scope="col" class="px-4 py-3">Event</th>
                            <th scope="col" class="px-4 py-3">Date</th>
                            <th scope="col" class="px-4 py-3">Total Attendees</th>
                            <th scope="col" class="px-4 py-3">Present</th>
                            <th scope="col" class="px-4 py-3">Late</th>
                            <th scope="col" class="px-4 py-3">Absent</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800">
                        <tr>
                            <td class="px-4 py-3">Orientation 2024</td>
                            <td class="px-4 py-3">August 15, 2024</td>
                            <td class="px-4 py-3">120</td>
                            <td class="px-4 py-3 text-green-400">110</td>
                            <td class="px-4 py-3 text-yellow-400">5</td>
                            <td class="px-4 py-3 text-red-400">5</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3">Sportsfest</td>
                            <td class="px-4 py-3">September 10, 2024</td>
                            <td class="px-4 py-3">150</td>
                            <td class="px-4 py-3 text-green-400">140</td>
                            <td class="px-4 py-3 text-yellow-400">7</td>
                            <td class="px-4 py-3 text-red-400">3</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>








</div>