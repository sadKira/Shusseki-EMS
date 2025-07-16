<div class="flex flex-col gap-3">
    
    {{-- Sub headings --}}
    <div class="flex gap-3 items-stretch">

        <div class="bg-(--import) rounded-xl px-10 py-6">
            <div class="flex items-center gap-5 whitespace-nowrap">
                <flux:icon.user class="text-zinc-50 size-10" variant="solid" />
                <div class="flex flex-col">
                    <flux:text>User Count</flux:text>
                    @if ($totalApproved != 0)
                        <flux:heading size="xl" level="1">{{ $totalApproved }} {{$totalApproved > 1 ? "Students" : "Student"}}
                        </flux:heading>
                    @else
                        <flux:heading size="xl" level="1">{{ $totalApproved }} Students
                        </flux:heading>
                    @endif
                    <flux:text variant="subtle">A.Y. {{ $schoolYear }}</flux:text>
                </div>
            </div>
        </div>

        {{-- Active & Inactive students --}}
        <div class="bg-(--import) rounded-xl px-10 py-6">
            <div class="flex flex-col  whitespace-nowrap">
                <flux:text>Active</flux:text>
                @if ($activeCount != 0)
                    <flux:heading size="xl" level="1">{{ $activeCount }} {{$activeCount > 1 ? "Students" : "Student"}}
                    </flux:heading>
                @else
                    <flux:heading size="xl" level="1">{{ $activeCount }} Students
                    </flux:heading>
                @endif
                <div class="flex items-center gap-1">
                    <flux:icon.arrow-trending-up class="text-green-500" variant="micro" />
                    <span class="text-sm text-green-600 dark:text-green-500">{{ $activePercentage }}% +</span>
                </div>
            </div>
        </div>

        <div class="bg-(--import) rounded-xl px-10 py-6">
            <div class="flex flex-col  whitespace-nowrap">
                <flux:text>Inactive</flux:text>
                @if ($inactiveCount != 0)
                    <flux:heading size="xl" level="1">{{ $inactiveCount }} {{$inactiveCount > 1 ? "Students" : "Student"}}
                    </flux:heading>
                @else
                    <flux:heading size="xl" level="1">{{ $inactiveCount }} Students
                    </flux:heading>
                @endif
                <div class="flex items-center gap-1">
                    <flux:icon.arrow-trending-down class="text-red-500" variant="micro" />
                    <span class="text-sm text-red-500 dark:text-red-500">{{ $inactivePercentage }}% -</span>
                </div>
            </div>
        </div>  

    </div>


    <div class="bg-(--import) rounded-xl px-10 py-6">
        {{-- Filters --}}
        <div class="flex items-center justify-between max-lg:hidden">
            <div class="flex items-center space-x-1">

                {{-- Hide if multi select is enabled --}}
                @if ($selection)

                    {{-- Active and inactive students filter --}}
                    {{-- <flux:radio.group wire:model.live="selectedStatus" variant="segmented">
                        <flux:radio value="Active Students" label="Active Students" />
                        <flux:radio value="Inactive Students" label="Inactive Students" />
                    </flux:radio.group> --}}
                    <div class="flex items-center gap-2">
                        <flux:heading size="xl" level="1"><span class="text-[var(--color-accent)]">{{ $selectedStatus }}</span></flux:heading>
                        <flux:dropdown>
                            <flux:button icon="chevron-down" variant="ghost"></flux:button>
                            <flux:menu>
                                <flux:menu.radio.group  wire:model.live="selectedStatus">
                                    <flux:menu.radio value="Active Students" checked>Active Students</flux:menu.radio>
                                    <flux:menu.radio value="Inactive Students">Inactive Students</flux:menu.radio>
                                </flux:menu.radio.group>
                            </flux:menu>
                        </flux:dropdown>
                    </div>

                    {{-- Super admin capabilities --}}
                    @can('SA')

                        @if (
                                ($selectedStatus === 'Active Students' && $activeCount > 1) ||
                                ($selectedStatus === 'Inactive Students' && $inactiveCount > 1)
                            )
                            <flux:button variant="subtle" wire:click.live="toggleSelection">Select Multiple</flux:button>
                        @endif

                    @endcan

                    {{-- When multi-select is enabled --}}
                @else

                    <flux:button variant="danger" icon="x-mark" wire:click="toggleSelection">Cancel</flux:button>

                    {{-- If active students --}}
                    @if ($selectedStatus == 'Active Students')
                        {{-- Selection Count Button --}}
                        <flux:button variant="filled"
                            class="ml-3 {{ $selection == false ? 'opacity-100' : 'opacity-0 pointer-events-none' }}">
                            {{ count($selected) }} selected
                        </flux:button>

                        {{-- if inactive students --}}
                    @else
                        {{-- Selection Count Button --}}
                        <flux:button variant="filled"
                            class="ml-3 {{ $selection == false ? 'opacity-100' : 'opacity-0 pointer-events-none' }}">
                            {{ count($selected) }} selected
                        </flux:button>

                    @endif

                @endif

            </div>

            {{-- Search --}}
            @if ($selection)
                <div class="flex items-center gap-2">

                    {{-- Display filters only when active students are selected --}}
                    @if ($selectedStatus == 'Active Students')
                        {{-- Don't display filters if there are no students --}}
                        @if ($activeCount > 1)
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down" variant="filled">Filter</flux:button>

                                <flux:menu>
                                    <flux:menu.submenu heading="Year Level">
                                        <flux:menu.radio.group wire:model.live="selectedStatus_level">
                                            <flux:menu.radio checked value="All">All</flux:menu.radio>
                                            <flux:menu.radio value="1st Year">1st Year</flux:menu.radio>
                                            <flux:menu.radio value="2nd Year">2nd Year</flux:menu.radio>
                                            <flux:menu.radio value="3rd Year">3rd Year</flux:menu.radio>
                                            <flux:menu.radio value="4th Year">4th Year</flux:menu.radio>
                                        </flux:menu.radio.group>
                                    </flux:menu.submenu>

                                    <flux:menu.submenu heading="Course" wire:model.live="selectedStatus_course">
                                        <flux:menu.radio.group wire:model.live="selectedStatus_course">
                                            <flux:menu.radio checked value="All">All</flux:menu.radio>
                                            <flux:menu.radio value="Bachelor of Arts in International Studies">
                                                Bachelor of Arts in International Studies</flux:menu.radio>
                                            <flux:menu.radio value="Bachelor of Science in Information Systems">
                                                Bachelor of Science in Information Systems</flux:menu.radio>
                                            <flux:menu.radio value="Bachelor of Human Services">
                                                Bachelor of Human Services</flux:menu.radio>
                                            <flux:menu.radio value="Bachelor of Secondary Education">
                                                Bachelor of Secondary Education</flux:menu.radio>
                                        </flux:menu.radio.group>
                                    </flux:menu.submenu>

                                    {{-- Clear filter --}}
                                    @if ($selectedStatus_level !== 'All' || $selectedStatus_course !== 'All' || $search !== '')
                                        <flux:menu.separator />
                                        <flux:menu.item icon="x-mark" wire:click="clearFilters" variant="danger">
                                            Clear Filters
                                        </flux:menu.item>
                                    @endif

                                </flux:menu>
                            </flux:dropdown>
                        @endif
                    @endif

                    {{-- Search field --}}
                    <flux:input icon="magnifying-glass" placeholder="Search..." wire:model.live.debounce.300ms="search" autocomplete="off" clearable />
                </div>
            @else
                {{-- Bulk Buttons Container --}}
                <div>
                    <flux:dropdown position="bottom" align="end">
                        <flux:button icon:trailing="chevron-down" variant="primary" color="amber">Bulk Actions
                        </flux:button>
                        <flux:menu>
                            @if ($selectedStatus == 'Active Students')
                                @if (count($selected) > 0)
                                    <flux:menu.item icon="check" wire:click="bulkmarkInactive">Mark selected as inactive
                                    </flux:menu.item>
                                @else
                                    <flux:menu.item icon="user-plus" wire:confirm="Mark all existing accounts as inactive?"
                                        wire:click="totalbulkmarkInactive">Mark all accounts as inactive</flux:menu.item>
                                @endif
                            @else
                                @if (count($selected) > 0)
                                    <flux:menu.item icon="check" wire:click="bulkmarkActive">Mark selected as active
                                    </flux:menu.item>
                                    <flux:menu.item icon="x-mark" wire:click="bulkremoveAccount">Remove selected accounts
                                    </flux:menu.item>
                                @else
                                    <flux:menu.item icon="user-plus" wire:confirm="Mark all existing accounts as active?"
                                        wire:click="totalbulkmarkActive">Mark all accounts as active</flux:menu.item>
                                    <flux:menu.item icon="trash" variant="danger" wire:confirm="Delete all existing accounts?"
                                        wire:click="totalbulkremoveAccount">
                                        Remove all existing accounts
                                    </flux:menu.item>
                                @endif
                            @endif
                        </flux:menu>
                    </flux:dropdown>
                </div>
            @endif
        </div>

        {{-- Table --}}
        <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
            <flux:checkbox.group>
                <table class="w-full text-sm text-left rtl:text-right text-zinc-600 dark:text-zinc-400">
                    <thead class="text-xs text-zinc-700 uppercase dark:bg-[--import] dark:text-zinc-300">
                        <tr>
                            @if ($selection)
                            @else
                                <th scope="col" class="p-4">
                                </th>
                            @endif
                            <th scope="col" class="px-6 py-3 whitespace-nowrap p-3 cursor-pointer"
                                wire:click="sortBy('name')">
                                <div class="class flex items-center gap-2">
                                    Student Name
                                    @if ($sortField === 'name')
                                        @if ($sortDirection === 'asc')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                                            </svg>

                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                            </svg>

                                        @endif
                                    @endif
                                </div>

                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                @if ($selectedStatus == 'Active Students')
                                    Email
                                @else
                                    Status
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                Year
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Course
                            </th>
                            <th scope="col" class="px- py-3 pl-16.5">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr wire:key="{{ $user->id }}"
                                class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700 border-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                @if ($selection)
                                @else
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <flux:checkbox value="{{ $user->id }}" wire:model.live="selected" />
                                        </div>
                                    </td>
                                @endif
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-zinc-100">
                                    {{ $user->name }}
                                </th>
                                {{-- text-zinc-600 --}}
                                <td class="px-6 py-4  dark:text-zinc-400">
                                    @if ($selectedStatus == 'Active Students')
                                        {{ $user->email }}
                                    @else
                                        <span class="text-[var(--color-amber-400)]">{{ $user->account_status->label() }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400 whitespace-nowrap">
                                    <span
                                        class="{{ $selectedStatus_level != 'All' ? 'text-[var(--color-amber-400)]' : '' }}">{{ $user->year_level }}</span>
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    <span
                                        class="{{ $selectedStatus_course != 'All' ? 'text-[var(--color-amber-400)]' : '' }}">{{ $user->course }}</span>
                                </td>
                                <td class="flex items-center space-between gap-4 px-6 py-4">
                                    @can ('SA')
                                        @if ($selection)
                                            @if ($selectedStatus == 'Active Students')
                                                <flux:dropdown position="left" align="end">
                                                    <flux:button icon="ellipsis-horizontal" variant="ghost"></flux:button>
                                                    <flux:menu>
                                                        <flux:menu.item variant="danger" icon="user-minus"
                                                            wire:click="markInactive({{ $user->id }})">Mark as
                                                            Inactive</flux:menu.item>
                                                    </flux:menu>
                                                </flux:dropdown>
                                            @else
                                                <flux:dropdown position="left" align="end">
                                                    <flux:button icon="ellipsis-horizontal" variant="ghost"></flux:button>
                                                    <flux:menu>
                                                        <flux:menu.item icon="user-plus" wire:click="markActive({{ $user->id }})">
                                                            Mark as Active</flux:menu.item>
                                                        <flux:menu.item icon="trash" variant="danger"
                                                            wire:confirm="Confirm account removal."
                                                            wire:click="removeAccount({{ $user->id }})">
                                                            Remove Account</flux:menu.item>
                                                    </flux:menu>
                                                </flux:dropdown>
                                            @endif
                                        @else
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                @if ($selectedStatus == 'Active Students')
                                    <td colspan="6" class="text-center py-8 text-lg text-zinc-400 font-semibold">
                                        No Active Student Accounts
                                    </td>
                                @elseif ($selectedStatus == 'Inactive Students')
                                    <td colspan="6" class="text-center py-8 text-lg text-zinc-400 font-semibold">
                                        No Inactive Student Accounts
                                    </td>
                                @endif
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </flux:checkbox.group>
        </div>

        {{-- @script
        <script>
            setInterval(() => {
                $wire.$refresh()
            }, 5000)
        </script>
        @endscript --}}


        <div class="mt-4">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>

</div>