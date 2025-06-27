<div>
    <div class="mt-5 flex items-center justify-between max-lg:hidden">
        <div class="flex items-center space-x-1">

            {{-- Active and inactive students filter --}}
            <flux:dropdown>
                <flux:button variant="primary" color="amber" icon:trailing="chevron-down">{{ $selectedStatus }}
                </flux:button>
                <flux:menu>
                    <flux:menu.radio.group wire:model.live="selectedStatus">
                        <flux:menu.radio checked value="Active Students">Active Students
                        </flux:menu.radio>
                        <flux:menu.radio value="Inactive Students">Inactive Students
                        </flux:menu.radio>
                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>

            @if ($selectedStatus == 'Active Students')

                <flux:text class="text-xs ml-3 mr-2" variant="strong">Year Level:</flux:text>
                {{-- Year level filter --}}
                <flux:dropdown>
                    <flux:button variant="ghost" icon:trailing="chevron-down">{{ $selectedStatus_level }}</flux:button>
                    <flux:menu>
                        <flux:menu.radio.group wire:model.live="selectedStatus_level">
                            <flux:menu.radio checked value="">{{ $selectedStatus_level }}</flux:menu.radio>
                            <flux:menu.radio value="1st Year">1st Year</flux:menu.radio>
                            <flux:menu.radio value="2nd Year">2nd Year</flux:menu.radio>
                            <flux:menu.radio value="3rd Year">3rd Year</flux:menu.radio>
                            <flux:menu.radio value="4th Year">4th Year</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>

                <flux:text class="text-xs ml-3 mr-2" variant="strong">Course:</flux:text>
                {{-- Course filter --}}
                <flux:dropdown>
                    <flux:button variant="ghost" icon:trailing="chevron-down">{{ $selectedStatus_course }}</flux:button>
                    <flux:menu>
                        <flux:menu.radio.group wire:model.live="selectedStatus_course">
                            <flux:menu.radio checked value="">{{ $selectedStatus_course }}</flux:menu.radio>
                            <flux:menu.radio value="Bachelor of Arts in International Studies">
                                Bachelor of Arts in International Studies</flux:menu.radio>
                            <flux:menu.radio value="Bachelor of Science in Information Systems">
                                Bachelor of Science in Information Systems</flux:menu.radio>
                            <flux:menu.radio value="Bachelor of Human Services">
                                Bachelor of Human Services</flux:menu.radio>
                            <flux:menu.radio value="Bachelor of Secondary Education">
                                Bachelor of Secondary Education</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>

                {{-- Clear filter --}}
                @if ($selectedStatus_level !== 'All' || $selectedStatus_course !== 'All' || $search !== '')
                    <flux:button variant="primary" icon="x-mark" wire:click="clearFilters" color="red">
                        Clear Filters
                    </flux:button>
                @endif

            @endif
        </div>

        <div class="flex items-cent gap-2">
            <flux:input icon="magnifying-glass" placeholder="Search..." wire:model.live.debounce.300ms="search" />
        </div>
    </div>

    {{-- Mobile view (A and I filter) --}}
    <div class="mt-5 relative justify-between lg:hidden">
        <div class="relative space-x-1">

            <div class="flex items-center gap-2">
                {{-- Active and inactive students filter --}}
                <flux:dropdown>
                    <flux:button variant="primary" color="amber" size="sm" icon:trailing="chevron-down">{{ $selectedStatus }}
                    </flux:button>
                    <flux:menu>
                        <flux:menu.radio.group wire:model.live="selectedStatus">
                            <flux:menu.radio checked value="Active Students">Active Students
                            </flux:menu.radio>
                            <flux:menu.radio value="Inactive Students">Inactive Students
                            </flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>

                {{-- Clear filter --}}
                @if ($selectedStatus_level !== 'All' || $selectedStatus_course !== 'All' || $search !== '')
                    <flux:button variant="primary" icon="x-mark" wire:click="clearFilters" color="red" size="sm">
                        Clear Filters
                    </flux:button>
                @endif
            </div>
            <div class="mt-2">
                @if ($selectedStatus == 'Active Students')

                    <div class="flex items-center">
                        <flux:text class="text-xs ml-3 mr-2" variant="strong">Year Level:</flux:text>
                        {{-- Year level filter --}}
                        <flux:dropdown>
                            <flux:button variant="ghost" icon:trailing="chevron-down">{{ $selectedStatus_level }}</flux:button>
                            <flux:menu>
                                <flux:menu.radio.group wire:model.live="selectedStatus_level">
                                    <flux:menu.radio checked value="">{{ $selectedStatus_level }}</flux:menu.radio>
                                    <flux:menu.radio value="1st Year">1st Year</flux:menu.radio>
                                    <flux:menu.radio value="2nd Year">2nd Year</flux:menu.radio>
                                    <flux:menu.radio value="3rd Year">3rd Year</flux:menu.radio>
                                    <flux:menu.radio value="4th Year">4th Year</flux:menu.radio>
                                </flux:menu.radio.group>
                            </flux:menu>
                        </flux:dropdown>
                    </div>

                    <div class="flex items-center">
                        <flux:text class="text-xs ml-3 mr-2" variant="strong">Course:</flux:text>
                        {{-- Course filter --}}
                        <flux:dropdown>
                            <flux:button variant="ghost" icon:trailing="chevron-down">{{ $selectedStatus_course }}</flux:button>
                            <flux:menu>
                                <flux:menu.radio.group wire:model.live="selectedStatus_course">
                                    <flux:menu.radio checked value="">{{ $selectedStatus_course }}</flux:menu.radio>
                                    <flux:menu.radio value="Bachelor of Arts in International Studies">
                                        Bachelor of Arts in International Studies</flux:menu.radio>
                                    <flux:menu.radio value="Bachelor of Science in Information Systems">
                                        Bachelor of Science in Information Systems</flux:menu.radio>
                                    <flux:menu.radio value="Bachelor of Human Services">
                                        Bachelor of Human Services</flux:menu.radio>
                                    <flux:menu.radio value="Bachelor of Secondary Education">
                                        Bachelor of Secondary Education</flux:menu.radio>
                                </flux:menu.radio.group>
                            </flux:menu>
                        </flux:dropdown>
                    </div>

                @endif   
            </div>         
        </div>
        <div class="mt-5"> 
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
                            Year Level
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
                                {{ $user->year_level }}
                            </td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                {{ $user->course }}
                            </td>
                            <td class="flex items-center space-between gap-4 px-6 py-4">
                                @if ($selectedStatus == 'Active Students')
                                    <flux:dropdown position="left" align="end">
                                        <flux:button icon="ellipsis-horizontal"></flux:button>
                                        <flux:menu>
                                            <flux:menu.item icon="user-minus" wire:click="markInactive({{ $user->id }})">Mark as
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