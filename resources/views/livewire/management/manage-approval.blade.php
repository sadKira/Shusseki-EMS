<div>
    <div class="flex flex-col gap-3">
        {{-- App Header --}}
        <div class=" relative mb-10 w-full">
            {{-- Breadcrumbs --}}
            <div class="mt-2">
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item :href="route('manage_students')" wire:navigate>Students
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item :href="route('manage_approval')" :accent="true" wire:navigate>
                        <span class="text-[var(--color-accent)]">Student Approval<span>
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
            <flux:heading size="xl" level="1">Student Approval</flux:heading>
        </div>

        {{-- Sub Headings --}}
        <div class="flex items-center justify-between max-lg:hidden">

            {{-- Sub Headings --}}
            <div class="px-10 py-6 bg-(--import) rounded-xl whitespace-nowrap">
                <flux:text>Pending Approval:</flux:text>
                <div class="flex items-center gap-2">
                    <flux:icon.user-group class="text-zinc-50" variant="solid" />
                    @if ($pendingCount > 1)
                        <flux:heading size="xl" level="1">
                            {{ $pendingCount }} Accounts Pending
                        </flux:heading>
                    @elseif ($pendingCount == 0)
                        <flux:heading size="xl" level="1"> No Accounts
                            Pending</flux:heading>
                    @else
                        <flux:heading size="xl" level="1">
                            {{ $pendingCount }} Account Pending
                        </flux:heading>
                    @endif
                </div>
            </div>

            {{-- Selection --}}
            <div class="flex items-center">

                {{-- Selection Count Button --}}
                <flux:button icon="x-mark" variant="filled" wire:click="cancelSelection"
                    class="{{ count($selected) > 0 ? 'opacity-100' : 'opacity-0 pointer-events-none' }}">
                    {{ count($selected) }} selected
                </flux:button>

                {{-- Bulk Buttons Container --}}
                <div class="ml-3 {{ $pendingCount > 1 ? 'opacity-100' : 'opacity-0 pointer-events-none' }}">
                    <flux:dropdown position="bottom" align="end">
                        <flux:button icon:trailing="chevron-down" variant="primary" color="amber">Bulk Actions</flux:button>
                        <flux:menu>
                            @if (count($selected) > 0)
                                <flux:menu.item icon="check" wire:click="bulkApprove">Approve Selected Accounts</flux:menu.item>
                                <flux:menu.item icon="x-mark" variant="danger" wire:confirm="Confirm bulk account rejection"
                                    wire:click="bulkReject">
                                    Reject Selected Accounts</flux:menu.item>
                                
                            @endif
                            @if (count($selected) > 0)
                            @else
                                <flux:menu.item icon="check-badge"  wire:confirm="Approve all existing accounts?"
                                    wire:click="totalbulkApprove">Approve All Pending Accounts</flux:menu.item>
                                <flux:menu.item icon="trash" variant="danger" wire:confirm="Delete all existing accounts?"
                                    wire:click="totalbulkReject">Reject All Pending Accounts</flux:menu.item>
                            @endif
                        </flux:menu>
                    </flux:dropdown>
                </div>

            </div>

        </div>

        @script
        <script>
            setInterval(() => {
                $wire.$refresh()
            }, 10000)
        </script>
        @endscript

        <div class="bg-(--import) rounded-xl px-10 py-6">
            {{-- Table --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <flux:checkbox.group>
                    <table class="w-full text-sm text-left rtl:text-right text-zinc-600 dark:text-zinc-400 ">
                        <thead class="text-xs text-zinc-700 uppercase dark:bg-(--import) dark:text-zinc-300">
                            <tr>
                                <th scope="col" class="p-4">
                                    {{-- <div class="flex items-center">
                                        <flux:checkbox.all wire:model.live="selectPage" />
                                    </div> --}}
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                    Student Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-5 py-3 whitespace-nowrap">
                                    Year Level
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Course
                                </th>
                                <th scope="col" class="px-6 py-3">
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $user)
                                <tr wire:key="user-{{ $user->id }} "
                                    class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700 border-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                    <td class="w-4 p-4">
                                        @if ($pendingCount > 1)
                                            <div class="flex items-center">
                                                <flux:checkbox value="{{ $user->id }}" wire:model.live="selected" />
                                            </div>
                                        @endif
                                    </td>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-zinc-100">
                                        {{ $user->name }}
                                    </th>
                                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                        {{ $user->year_level }}
                                    </td>
                                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                        {{ $user->course }}
                                    </td>
                                    <td class="flex items-center space-between gap-4 px-6 py-4">
                                        <flux:dropdown position="left" align="end">
                                            <flux:button icon="ellipsis-horizontal"></flux:button>
                                            <flux:menu>
                                                <flux:menu.item icon="check" wire:click="approve({{ $user->id }})">
                                                    Approve</flux:menu.item>
                                                <flux:menu.item icon="x-mark" variant="danger"
                                                    wire:confirm="Confirm account rejection." wire:click="reject({{ $user->id }})">
                                                    Reject</flux:menu.item>
                                            </flux:menu>
                                        </flux:dropdown>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-lg text-zinc-400 font-semibold">
                                        No Pending Accounts
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </flux:checkbox.group>
            </div>

            <div class="mt-4">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>