<div>

    {{-- App Header --}}
    <div class=" relative mb-6 w-full">
        <flux:heading size="xl" level="1">Student Approval</flux:heading>
        {{-- Breadcrumbs --}}
        <div class="mt-2 flex">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_students')" wire:navigate>Students
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_approval')" :accent="true" wire:navigate>
                    <span class="text-[var(--color-accent)]">Student Approval<span>
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
    </div>


    {{-- Main text --}}
    <div class="flex items-center space-x-5">
        {{-- Selection Count Button --}}
        <flux:button {{-- icon="x-mark" --}} variant="filled" {{-- wire:click="cancelSelection" --}}
            class="transition-opacity duration-300 {{ count($selected) > 1 ? 'opacity-100' : 'opacity-0 pointer-events-none' }}">
            {{ count($selected) }} selected
        </flux:button>

        {{-- Bulk Buttons Container --}}
        <div
            class="transition-opacity duration-300 {{ count($selected) > 1 ? 'opacity-100' : 'opacity-0 pointer-events-none' }}">
            <flux:button variant="primary" color="Amber" wire:click="bulkApprove">Bulk Approve</flux:button>
            <flux:button variant="danger" wire:confirm="Confirm account rejection" wire:click="bulkReject">Bulk
                Reject</flux:button>
        </div>

    </div>


    @script
    <script>
        setInterval(() => {
            $wire.$refresh()
        }, 5000)
    </script>
    @endscript

    {{-- Table --}}
    <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
        <flux:checkbox.group>
            <table class="w-full text-sm text-left rtl:text-right text-zinc-600 dark:text-zinc-400 ">
                <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <flux:checkbox.all wire:model="selectPage" />
                            </div>
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
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }} "
                            class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700 border-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800  {{ in_array((string) $user->id, $selected) ? 'bg-amber-100 dark:bg-amber-900' : 'bg-white dark:bg-zinc-900' }}">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <flux:checkbox value="{{ $user->id }}" wire:click="toggleSelect({{ $user->id }})" />
                                </div>
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
                                {{-- <flux:button variant="primary" color="Amber" wire:click="approve({{ $user->id }})">
                                    Approve</flux:button>
                                <flux:button variant="danger" wire:confirm="Confirm account rejection."
                                    wire:click="reject({{ $user->id }})">Reject</flux:button> --}}

                                <flux:dropdown position="left" align="end">
                                    <flux:button icon="ellipsis-horizontal"></flux:button>
                                    <flux:menu>
                                        <flux:menu.item icon="check" wire:click="approve({{ $user->id }})">
                                            Approve</flux:menu.item>
                                        <flux:menu.item icon="x-mark" variant="danger"  wire:confirm="Confirm account rejection." wire:click="reject({{ $user->id }})">
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