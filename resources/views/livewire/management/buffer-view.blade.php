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

    <div class="p-6 bg-zinc-950 min-h-screen text-white space-y-8">

        {{-- Pending Accounts Indicator --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="metallic-card-soft p-4 flex items-center justify-between">
                <div>
                    <p class="text-sm text-zinc-400">Pending Approvals</p>
                    <p class="text-3xl font-bold text-amber-400">{{ $pendingCount ?? 8 }}</p>
                </div>
                <div class="bg-amber-900/30 p-3 rounded-full">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending Students Table --}}
        <div class="metallic-card-soft p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Pending Student Accounts</h2>
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-sm font-medium shadow">
                    Approve Selected
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-800 text-sm">
                    <thead>
                        <tr class="text-left text-zinc-400 uppercase text-xs">
                            <th class="px-4 py-2"><input type="checkbox" /></th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Course</th>
                            <th class="px-4 py-2">Year Level</th>
                            <th class="px-4 py-2 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800">
                        <tr>
                            <td class="px-4 py-2"><input type="checkbox" /></td>
                            <td class="px-4 py-2 text-zinc-300">Jane Doe</td>
                            <td class="px-4 py-2 text-zinc-300">jane.doe@example.com</td>
                            <td class="px-4 py-2 text-zinc-300">BSIT</td>
                            <td class="px-4 py-2 text-zinc-300">3rd Year</td>
                            <td class="px-4 py-2 text-right">
                                <button
                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 rounded text-xs">Approve</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2"><input type="checkbox" /></td>
                            <td class="px-4 py-2 text-zinc-300">John Smith</td>
                            <td class="px-4 py-2 text-zinc-300">john.smith@example.com</td>
                            <td class="px-4 py-2 text-zinc-300">BSA</td>
                            <td class="px-4 py-2 text-zinc-300">2nd Year</td>
                            <td class="px-4 py-2 text-right">
                                <button
                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 rounded text-xs">Approve</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>






</div>