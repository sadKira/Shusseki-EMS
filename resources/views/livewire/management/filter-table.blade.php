<div>
    <div class="flex flex-col">

        {{-- Sub Headings --}}
        <div class="relative items-center">
            <flux:heading size="xl" level="1">{{ $totalApproved }} {{$totalApproved > 1 ? "Users" : "User"}}</flux:heading>
            <div class="flex items-center gap-2 mt-2">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4 text-green-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                    <flux:heading size="l" level="1">{{ $activeCount }} Active</flux:heading>
                </div>

                <flux:separator vertical />

                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4 text-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                    </svg>
                    <flux:heading size="l" level="1">{{ $inactiveCount }} Inactive</flux:heading>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="mt-10 flex items-center justify-between max-lg:hidden">
            <div class="flex items-center space-x-1">

                {{-- Active and inactive students filter --}}
                <flux:radio.group color="amber" wire:model.live="selectedStatus" variant="segmented">
                    <flux:radio value="Active Students" label="Active Students" />
                    <flux:radio value="Inactive Students" label="Inactive Students" />
                </flux:radio.group>

                @if ($selectedStatus == 'Active Students')
                    <flux:dropdown>
                        <flux:button icon:trailing="chevron-down" variant="ghost">Filter</flux:button>

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

            </div>

            <div class="flex items-center gap-2">
                @if ($search !== '')
                    <flux:button variant="danger" icon="x-mark" wire:click="clearFilters" />
                @endif
                <flux:input icon="magnifying-glass" placeholder="Search..." wire:model.live.debounce.300ms="search" />
            </div>
        </div>

    </div>

    {{-- Mobile view (A and I filter) --}}
    <div class="mt-5 relative justify-between lg:hidden">`
        <div class="flex items-center space-x-1">
            <div class="">
                {{-- Active and inactive students filter --}}
                <flux:radio.group color="amber" wire:model.live="selectedStatus" variant="segmented">
                    <flux:radio value="Active Students" label="Active Students" />
                    <flux:radio value="Inactive Students" label="Inactive Students" />
                </flux:radio.group>
            </div>
            <div class="">
                @if ($selectedStatus == 'Active Students')
                    <flux:dropdown>
                        <flux:button icon:trailing="chevron-down" variant="ghost">Filter</flux:button>

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

            </div>
            @if ($search !== '')
                <flux:button variant="danger" icon="x-mark" wire:click="clearFilters" />
            @endif
        </div>
        <div class="flex items-center mt-5">
            <flux:input icon="magnifying-glass" placeholder="Search..." />
        </div>
    </div>




    {{-- Table --}}
    <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
        <flux:checkbox.group>
            <table class="w-full text-sm text-left rtl:text-right text-zinc-600 dark:text-zinc-400">
                <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300">
                    <tr>
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
                        <th scope="col" class="px-6 py-3">
                            Email
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
                            <th scope="row"
                                class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-zinc-100">
                                {{ $user->name }}
                            </th>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                <span class="{{ $selectedStatus_level != 'All' ? 'text-[var(--color-amber-400)]' : '' }}">{{ $user->year_level }}</span>
                            </td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                <span class="{{ $selectedStatus_course != 'All' ? 'text-[var(--color-amber-400)]' : '' }}">{{ $user->course }}</span>
                            </td>
                            <td class="flex items-center space-between gap-4 px-6 py-4">
                                @if ($selectedStatus == 'Active Students')
                                    <flux:dropdown position="left" align="end">
                                        <flux:button icon="ellipsis-horizontal"></flux:button>
                                        <flux:menu>
                                            <flux:menu.item variant="danger" icon="user-minus" wire:click="markInactive({{ $user->id }})">Mark as
                                                Inactive</flux:menu.item>
                                        </flux:menu>
                                    </flux:dropdown>
                                @else
                                    <flux:dropdown position="left" align="end">
                                        <flux:button icon="ellipsis-horizontal"></flux:button>
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

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-lg text-zinc-400 font-semibold">
                                No Student Accounts
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