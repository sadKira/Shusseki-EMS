<div class="flex flex-col gap-3">

    {{-- Sub headings --}}
    <div class="flex gap-14 items-center justify-center-safe">

        <div class="px-7 py-6 whitespace-nowrap grid justify-items-center">

            <flux:text>User Count</flux:text>
            @if ($totalApproved != 0)
                <flux:heading size="xl" level="1">{{ $totalApproved }} {{$totalApproved > 1 ? "Students" : "Student"}}
                </flux:heading>
            @else
                <flux:heading size="xl" level="1">{{ $totalApproved }} Students
                </flux:heading>
            @endif
            {{-- <flux:text variant="subtle">A.Y. {{ $schoolYear }}</flux:text> --}}

        </div>

        {{-- Active & Inactive students --}}
        <div class="px-7 py-6 whitespace-nowrap grid justify-items-center">
            <flux:text>Active Student Accounts</flux:text>
            <div class="flex items-end gap-2">

                <flux:heading size="xl" level="1">{{ $activeCount }}</flux:heading>

                <div class="flex items-center gap-1">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-4 text-green-500">
                        <path fill-rule="evenodd"
                            d="M15.22 6.268a.75.75 0 0 1 .968-.431l5.942 2.28a.75.75 0 0 1 .431.97l-2.28 5.94a.75.75 0 1 1-1.4-.537l1.63-4.251-1.086.484a11.2 11.2 0 0 0-5.45 5.173.75.75 0 0 1-1.199.19L9 12.312l-6.22 6.22a.75.75 0 0 1-1.06-1.061l6.75-6.75a.75.75 0 0 1 1.06 0l3.606 3.606a12.695 12.695 0 0 1 5.68-4.974l1.086-.483-4.251-1.632a.75.75 0 0 1-.432-.97Z"
                            clip-rule="evenodd" />
                    </svg>

                    <flux:text class="text-xs dark:text-green-500">{{ $activePercentage }}%</flux:text>
                </div>
            </div>

        </div>

        <div class="px-7 py-6 whitespace-nowrap grid justify-items-center">
            <flux:text>Inactive Student Accounts</flux:text>
            <div class="flex items-end gap-2">
                
                <flux:heading size="xl" level="1">{{ $inactiveCount }}
                </flux:heading>
              
                <div class="flex items-center gap-1">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-4 text-red-500">
                        <path fill-rule="evenodd"
                            d="M1.72 5.47a.75.75 0 0 1 1.06 0L9 11.69l3.756-3.756a.75.75 0 0 1 .985-.066 12.698 12.698 0 0 1 4.575 6.832l.308 1.149 2.277-3.943a.75.75 0 1 1 1.299.75l-3.182 5.51a.75.75 0 0 1-1.025.275l-5.511-3.181a.75.75 0 0 1 .75-1.3l3.943 2.277-.308-1.149a11.194 11.194 0 0 0-3.528-5.617l-3.809 3.81a.75.75 0 0 1-1.06 0L1.72 6.53a.75.75 0 0 1 0-1.061Z"
                            clip-rule="evenodd" />
                    </svg>


                    <flux:text class="text-xs dark:text-red-500">{{ $inactivePercentage }}%</flux:text>
                </div>
            </div>

        </div>

        <div class="px-7 py-6 whitespace-nowrap grid justify-items-center">
            <flux:text>Tsuushin Officer</flux:text>
            <div class="flex items-end gap-2">
                
                @if ($tsuushinCount < 1)
                    <flux:heading size="xl" level="1">No Officer Set
                    </flux:heading>
                @else
                    <flux:heading size="xl" level="1">{{ $tsuushinCount }} Officer Set
                    </flux:heading>
                @endif
              
            </div>

        </div>

    </div>

    {{-- Content Main --}}
    <div class="metallic-card-soft rounded-xl px-7 py-6">

        {{-- Filters --}}
        <div class="flex items-center justify-between max-lg:hidden">
            <div class="flex items-center space-x-1">

                {{-- Hide if multi select is enabled --}}
                @if ($selection)

                    {{-- Active and inactive students filter --}}
                    {{-- Option 1 --}}
                    {{-- <flux:radio.group wire:model.live="selectedStatus" variant="segmented">
                        <flux:radio value="Active Accounts" label="Active Accounts" />
                        <flux:radio value="Inactive Accounts" label="Inactive Accounts" />
                    </flux:radio.group> --}}

                    {{-- Option 2 --}}
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            @if ($selectedStatus == 'Active Accounts')
                                <svg fill="#00C951" width="32px" height="32px" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" stroke="#00C951">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M7.8 10a2.2 2.2 0 0 0 4.4 0 2.2 2.2 0 0 0-4.4 0z"></path>
                                    </g>
                                </svg>
                            @else
                                <svg fill="#FB2C36" width="32px" height="32px" viewBox="0 0 20 20" 
                                    xmlns="http://www.w3.org/2000/svg" stroke="#FB2C36">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M7.8 10a2.2 2.2 0 0 0 4.4 0 2.2 2.2 0 0 0-4.4 0z"></path>
                                    </g>
                                </svg>
                            @endif

                            <flux:heading size="lg" level="1"><span class="text-zinc-50">{{ $selectedStatus
                                    }}</span></flux:heading>
                        </div>
                        
                        <flux:dropdown>
                            <flux:button icon="chevron-down" variant="ghost" size="sm"></flux:button>
                            <flux:menu>
                                <flux:menu.radio.group wire:model.live="selectedStatus">
                                    <flux:menu.radio value="Active Accounts" checked>Active Accounts</flux:menu.radio>
                                    <flux:menu.radio value="Inactive Accounts">Inactive Accounts</flux:menu.radio>
                                </flux:menu.radio.group>
                            </flux:menu>
                        </flux:dropdown>
                    </div>


                    {{-- Super admin capabilities --}}
                    {{-- @can('SA')

                        @if (
                        ($selectedStatus === 'Active Accounts' && $activeCount > 1) ||
                        ($selectedStatus === 'Inactive Accounts' && $inactiveCount > 1)
                        )
                        <flux:button variant="subtle" wire:click="toggleSelection">Select Multiple</flux:button>
                        @endif

                    @endcan --}}

                    {{-- When multi-select is enabled --}}
                @else

                    <flux:button variant="danger" icon="x-mark" wire:click="toggleSelection">Cancel</flux:button>

                    {{-- If active students --}}
                    @if ($selectedStatus == 'Active Accounts')
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
                    @if ($selectedStatus == 'Active Accounts')
                        {{-- Don't display filters if there are no students --}}
                        @if ($activeCount > 1)
                            <flux:button.group>
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

                                {{-- Super admin capabilities --}}
                                @can('SA')

                                    @if (
                                            ($selectedStatus === 'Active Accounts' && $activeCount > 1) ||
                                            ($selectedStatus === 'Inactive Accounts' && $inactiveCount > 1)
                                        )
                                        <flux:button variant="filled" icon:trailing="cursor-arrow-rays" wire:click="toggleSelection">Select
                                        </flux:button>
                                    @endif

                                @endcan

                            </flux:button.group>
                       

                        @endif
                    @elseif ($selectedStatus == 'Inactive Accounts')

                        {{-- Super admin capabilities --}}
                        @can('SA')

                            @if (
                                    ($selectedStatus === 'Active Accounts' && $activeCount > 1) ||
                                    ($selectedStatus === 'Inactive Accounts' && $inactiveCount > 1)
                                )
                                <flux:button variant="filled" icon:trailing="cursor-arrow-rays" wire:click="toggleSelection">Select
                                </flux:button>
                            @endif

                        @endcan
                    @endif

                    {{-- Search field --}}
                    @if (
                                    ($selectedStatus === 'Active Accounts' && $activeCount > 1) ||
                                    ($selectedStatus === 'Inactive Accounts' && $inactiveCount > 1)
                                )
                        <flux:input icon="magnifying-glass" placeholder="Search Student" wire:model.live.debounce.300ms="search"
                            autocomplete="off" clearable />
                    @endif
                    
                </div>
            @else
                {{-- Bulk Buttons Container --}}
                <div>
                    <flux:dropdown position="bottom" align="end">
                        <flux:button icon:trailing="chevron-down" variant="primary" color="amber">Bulk Actions
                        </flux:button>
                        <flux:menu>
                            @if ($selectedStatus == 'Active Accounts')
                                @if (count($selected) > 0)
                                    <flux:modal.trigger name="inactive-selected">
                                        <flux:menu.item icon="check">Mark selected as inactive</flux:menu.item>
                                    </flux:modal.trigger>
                                @else
                                    <flux:modal.trigger name="inactive-bulk">
                                        <flux:menu.item icon="user-plus">Mark all accounts as inactive</flux:menu.item>
                                    </flux:modal.trigger>
                                @endif
                            @else
                                @if (count($selected) > 0)
                                    <flux:modal.trigger name="active-selected">
                                        <flux:menu.item icon="check">Mark selected as active</flux:menu.item>
                                    </flux:modal.trigger>
                                    <flux:modal.trigger name="remove-selected">
                                        <flux:menu.item icon="x-mark">Remove selected accounts</flux:menu.item>
                                    </flux:modal.trigger>
                                @else
                                    <flux:modal.trigger name="active-bulk">
                                        <flux:menu.item icon="user-plus">Mark all accounts as active</flux:menu.item>
                                    </flux:modal.trigger>
                                    <flux:modal.trigger name="remove-bulk">
                                        <flux:menu.item icon="trash" variant="danger">Remove all existing accounts</flux:menu.item>
                                    </flux:modal.trigger>
                                @endif
                            @endif
                        </flux:menu>
                    </flux:dropdown>
                </div>
            @endif
        </div>




        {{-- Table --}}
        <div>
            <div class="flex flex-col mt-5">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full">
                                <thead class="">
                                    <tr>
                                        @if ($selection)
                                        @else
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-gray-500 dark:text-neutral-300">
                                            </th>
                                        @endif

                                        <th scope="col"
                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 dark:text-zinc-400"
                                            wire:click="sortBy('name')">
                                            <div class="flex items-center gap-2">
                                                Student
                                                @if ($sortField === 'name')
                                                    @if ($sortDirection === 'asc')
                                                        {{-- <svg xmlns="http://www.w3.org/3000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                                                        </svg> --}}
                                                        <flux:icon.arrows-up-down variant="micro" />

                                                    @else
                                                        {{-- <svg xmlns="http://www.w3.org/3000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                                        </svg> --}}
                                                        <flux:icon.arrow-down variant="micro" />

                                                    @endif
                                                @endif
                                                <div>
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 dark:text-neutral-400">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 dark:text-neutral-400">
                                            Year Level</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 dark:text-neutral-400">
                                            Course</th>
                                        @can('SA')
                                        
                                            @if ($selection)
                                                <th scope="col"
                                                    class="px-6 py-3 text-sm font-medium text-gray-500 dark:text-neutral-400">
                                                    Action</th>
                                            @else
                                            @endif

                                        @endcan
                                        @can('A')
                                            @if ($selectedStatus == 'Active Accounts')
                                                <th scope="col"
                                                    class="px-6 py-3 text-sm font-medium text-gray-500 dark:text-neutral-400">
                                                    Action</th>
                                            @endif
                                        @endcan


                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                    @if($users->isEmpty())
                                        @if(!empty($search))
                                            <tr class="">
                                                @if ($selectedStatus == 'Active Accounts')
                                                    <td
                                                        colspan="7" class="px-6 py-10 whitespace-nowrap text-sm  text-gray-800 dark:text-neutral-200">
                                                        <div class="flex justify-center items-center gap-2 w-full">
                                                            <flux:icon.magnifying-glass variant="solid" class="text-zinc-50" />
                                                            <flux:heading size="lg">No Active Student Found</flux:heading>
                                                        </div>
                                                    </td>
                                                @elseif ($selectedStatus == 'Inactive Accounts')
                                                    <td
                                                        colspan="7" class="px-6 py-10 whitespace-nowrap text-sm  text-gray-800 dark:text-neutral-200">
                                                        <div class="flex justify-center items-center gap-2 w-full">
                                                            <flux:icon.magnifying-glass variant="solid" class="text-zinc-50" />
                                                            <flux:heading size="lg">No Inactive Student Found</flux:heading>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @else
                                            <tr class="">
                                                @if ($selectedStatus == 'Active Accounts')
                                                    <td
                                                        colspan="7" class="px-6 py-10 whitespace-nowrap text-sm  text-gray-800 dark:text-neutral-200">
                                                        <div class="flex justify-center items-center gap-2 w-full">
                                                            <flux:icon.user-circle variant="solid" class="text-zinc-50" />
                                                            <flux:heading size="lg">No Active Student Accounts</flux:heading>
                                                        </div>
                                                    </td>
                                                @elseif ($selectedStatus == 'Inactive Accounts')
                                                    <td
                                                        colspan="7" class="px-6 py-10 whitespace-nowrap text-sm  text-gray-800 dark:text-neutral-200">
                                                        <div class="flex justify-center items-center gap-2 w-full">
                                                            <flux:icon.user-circle variant="solid" class="text-zinc-50" />
                                                            <flux:heading size="lg">No Inactive Student Accounts</flux:heading>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endif
                                    @else
                                        @foreach ($users as $user)
                                            <tr wire:key="{{ $user->id }}" class="hover:bg-gray-100 dark:hover:bg-neutral-700 transition">
                                                @if ($selection)
                                                @else
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center">

                                                            @if ($user->tsuushin != \App\Enums\TsuushinRole::Member)
                                                                <flux:checkbox value="{{ $user->id }}" wire:model.live="selected" />
                                                            @endif

                                                        </div>
                                                    </td>
                                                @endif
                                                <td
                                                    class="!flex gap-2 px-6 py-4 text-sm font-medium text-gray-800 dark:text-neutral-200">

                                                    <flux:profile circle class="" 
                                                    avatar:name="{{ $user->name }}"
                                                    avatar:color="auto"
                                                    :chevron="false"
                                                    {{-- color:seed="{{ auth()->user()->id }}" --}}
                                                    />
                                                    <div class="!flex !flex-col">
                                                        <div class="flex items-center gap-2">
                                                            <div class="font-bold">{{ $user->name }}</div>
                                                            @if ($user->tsuushin == \App\Enums\TsuushinRole::Member)
                                                                <flux:badge variant="solid" size="sm" color="blue">MKD Tsuushin</flux:badge>
                                                            @endif
                                                        </div>
                                                        <div class="text-zinc-400">{{ $user->email }}</div>
                                                    </div>
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                    @if ($selectedStatus == 'Active Accounts')
                                                        <span
                                                            class="bg-transparent text-zinc-50 border border-neutral-500 inline-flex items-center text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                                            <span
                                                                class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                                                            <span>Active</span>
                                                        </span>
                                                    @else
                                                        <span
                                                            class="bg-transparent text-zinc-50 border border-neutral-500 inline-flex items-center text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                                            <span
                                                                class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-red-500 rounded-full"></span>
                                                            <span>Inactive</span>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-200">
                                                    <span class="{{ $selectedStatus_level != 'All' ? 'text-[var(--color-amber-400)]' : '' }}">{{ $user->year_level }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-200">
                                                    @php

                                                        $course = $user->course;

                                                        $output = match (true) {
                                                            $course == 'Bachelor of Arts in International Studies' => 'ABIS',
                                                            $course == 'Bachelor of Science in Information Systems' => 'BSIS',
                                                            $course == 'Bachelor of Human Services' => 'BHS',
                                                            $course == 'Bachelor of Secondary Education' => 'BSED',
                                                            default => 'Course',
                                                        };

                                                    @endphp
                                                    <span class="{{ $selectedStatus_course != 'All' ? 'text-[var(--color-amber-400)]' : '' }}">
                                                    {{ $output }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 ">

                                                    @can ('SA')
                                                        @if ($selection)
                                                            @if ($selectedStatus == 'Active Accounts')
                                                                <flux:dropdown position="left" align="end">
                                                                    <flux:button icon="ellipsis-horizontal" variant="filled" size="xs"
                                                                        class="ml-13"></flux:button>
                                                                    <flux:menu>

                                                                        @if ($tsuushinCount < 1)
                                                                            <flux:modal.trigger :name="'tag-tsuushin-'.$user->id">
                                                                                <flux:menu.item icon="camera">Tag as
                                                                                    Tsuushin</flux:menu.item>
                                                                            </flux:modal.trigger>
                                                                        @endif

                                                                        @if ($user->tsuushin != \App\Enums\TsuushinRole::Member)
                                                                            <flux:modal.trigger :name="'inactive-solo-'.$user->id">
                                                                                <flux:menu.item variant="danger" icon="user-minus">Mark as
                                                                                    Inactive</flux:menu.item>
                                                                            </flux:modal.trigger>
                                                                        @endif

                                                                        @if ($user->tsuushin == \App\Enums\TsuushinRole::Member)
                                                                            <flux:modal.trigger :name="'remove-tsuushin-'.$user->id">
                                                                                <flux:menu.item variant="danger" icon="minus-circle">Remove
                                                                                    Tsuushin Tag</flux:menu.item>
                                                                            </flux:modal.trigger>
                                                                        @endif

                                                                    </flux:menu>
                                                                </flux:dropdown>
                                                            @else
                                                                <flux:dropdown position="left" align="end">
                                                                    <flux:button icon="ellipsis-horizontal" variant="filled" size="xs"
                                                                        class="ml-13"></flux:button>
                                                                    <flux:menu>

                                                                        <flux:modal.trigger :name="'active-solo-'.$user->id">
                                                                            <flux:menu.item icon="user-plus">Mark as Active</flux:menu.item>
                                                                        </flux:modal.trigger>
                                                                        <flux:modal.trigger :name="'remove-solo-'.$user->id">
                                                                            <flux:menu.item icon="trash" variant="danger">Remove Account
                                                                            </flux:menu.item>
                                                                        </flux:modal.trigger>

                                                                    </flux:menu>
                                                                </flux:dropdown>
                                                            @endif
                                                        @else
                                                        @endif
                                                    @endcan

                                                    @can('A')

                                                        @if ($selectedStatus == 'Active Accounts')

                                                            @if ($tsuushinCount < 1)
                                                                <flux:dropdown position="left" align="end">
                                                                    <flux:button icon="ellipsis-horizontal" variant="filled" size="xs"
                                                                        class="ml-13"></flux:button>
                                                                    <flux:menu>

                                                                        @if ($tsuushinCount < 1)
                                                                            <flux:modal.trigger :name="'tag-tsuushin-'.$user->id">
                                                                                <flux:menu.item icon="camera">Tag as
                                                                                    Tsuushin</flux:menu.item>
                                                                            </flux:modal.trigger>
                                                                        @endif

                                                                    </flux:menu>
                                                                </flux:dropdown>
                                                            @else
                                                                @if ($user->tsuushin == \App\Enums\TsuushinRole::Member)
                                                                    <flux:dropdown position="left" align="end">
                                                                        <flux:button icon="ellipsis-horizontal" variant="filled" size="xs"
                                                                        class="ml-13"></flux:button>
                                                                        <flux:menu>

                                                                            @if ($user->tsuushin == \App\Enums\TsuushinRole::Member)
                                                                                <flux:modal.trigger :name="'remove-tsuushin-'.$user->id">
                                                                                    <flux:menu.item variant="danger" icon="minus-circle">Remove
                                                                                        Tsuushin Tag</flux:menu.item>
                                                                                </flux:modal.trigger>
                                                                            @endif

                                                                        </flux:menu>
                                                                    </flux:dropdown>
                                                                @else
                                                                    <flux:button icon="ellipsis-horizontal" variant="subtle" disabled size="xs"
                                                                    class="ml-13"></flux:button>
                                                                @endif
                                                            @endif

                                                        @endif
                                                        
                                                    @endcan

                                                    {{-- Mark inactive modal --}}
                                                    <flux:modal :name="'inactive-solo-'.$user->id" :dismissible="false"
                                                        class="min-w-[22rem]">
                                                        <div class="space-y-6">
                                                            <div>
                                                                <flux:heading size="lg">Mark Student as Inactive?</flux:heading>
                                                                <flux:text class="mt-2">
                                                                    <p>You're about to mark {{ $user->name }} as inactive.</p>
                                                                </flux:text>
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <flux:spacer />
                                                                <flux:modal.close>
                                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                                </flux:modal.close>
                                                                <flux:button variant="danger"
                                                                    wire:click="markInactive({{ $user->id }})">Mark as Inactive
                                                                </flux:button>
                                                            </div>
                                                        </div>
                                                    </flux:modal>

                                                    {{-- Mark active modal --}}
                                                    <flux:modal :name="'active-solo-'.$user->id" :dismissible="false"
                                                        class="min-w-[22rem]">
                                                        <div class="space-y-6">
                                                            <div>
                                                                <flux:heading size="lg">Mark Student as Active?</flux:heading>
                                                                <flux:text class="mt-2">
                                                                    <p>You're about to mark {{ $user->name }} as active.</p>
                                                                </flux:text>
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <flux:spacer />
                                                                <flux:modal.close>
                                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                                </flux:modal.close>
                                                                <flux:button variant="primary" color="amber"
                                                                    wire:click="markActive({{ $user->id }})">Mark as Active
                                                                </flux:button>
                                                            </div>
                                                        </div>
                                                    </flux:modal>

                                                    {{-- Remove account modal --}}
                                                    <flux:modal :name="'remove-solo-'.$user->id" :dismissible="false"
                                                        class="min-w-[22rem]">
                                                        <div class="space-y-6">
                                                            <div>
                                                                <flux:heading size="lg">Remove Account?</flux:heading>
                                                                <flux:text class="mt-2">
                                                                    <p>You're about to remove {{ $user->name }}'s account.</p>
                                                                    <p>This action cannot be undone.</p>
                                                                </flux:text>
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <flux:spacer />
                                                                <flux:modal.close>
                                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                                </flux:modal.close>
                                                                <flux:button variant="danger"
                                                                    wire:click="removeAccount({{ $user->id }})">Remove Account
                                                                </flux:button>
                                                            </div>
                                                        </div>
                                                    </flux:modal>

                                                    {{-- Tag as Tsuushin --}}
                                                    <flux:modal :name="'tag-tsuushin-'.$user->id" :dismissible="false"
                                                        class="min-w-[22rem]">
                                                        <div class="space-y-6">
                                                            <div>
                                                                <flux:heading size="lg">Tag Student as Tsuushin?</flux:heading>
                                                                <flux:text class="mt-2">
                                                                    <p>You're about to tag {{ $user->name }} as a Tsuushin member.</p>
                                                                    <p>They will receive media coverage requests.</p>
                                                                </flux:text>
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <flux:spacer />
                                                                <flux:modal.close>
                                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                                </flux:modal.close>
                                                                <flux:button variant="primary" color="blue"
                                                                    wire:click="markTsuushin({{ $user->id }})">Tag as Tsuushin
                                                                </flux:button>
                                                            </div>
                                                        </div>
                                                    </flux:modal>

                                                    {{-- Remove Tsuushin Tag --}}
                                                    <flux:modal :name="'remove-tsuushin-'.$user->id" :dismissible="false"
                                                        class="min-w-[22rem]">
                                                        <div class="space-y-6">
                                                            <div>
                                                                <flux:heading size="lg">Remove Tsuushin Tag?</flux:heading>
                                                                <flux:text class="mt-2">
                                                                    <p>You're about to remove {{ $user->name }}'s Tsuushin tag.</p>
                                                                    <p>They will not receive media coverage requests.</p>
                                                                </flux:text>
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <flux:spacer />
                                                                <flux:modal.close>
                                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                                </flux:modal.close>
                                                                <flux:button variant="danger"
                                                                    wire:click="removeTsuushin({{ $user->id }})">Remove Tag
                                                                </flux:button>
                                                            </div>
                                                        </div>
                                                    </flux:modal>

                                                </td>
                                            </tr>
                                     
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>



    </div>

    {{-- Bulk inactive modal --}}
    <flux:modal name="inactive-bulk" :dismissible="false" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Mark All Students as Inactive?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to mark all students as inactive.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="totalbulkmarkInactive">Mark as Inactive</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Bulk active modal --}}
    <flux:modal name="active-bulk" :dismissible="false" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Mark All Students as Active?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to mark all students as active.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="amber" wire:click="totalbulkmarkActive">Mark as Active
                </flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Bulk remove modal --}}
    <flux:modal name="remove-bulk" :dismissible="false" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Remove All Students?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to remove all students. This action</p>
                    <p>cannot be undone.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="totalbulkremoveAccount">Remove all Students</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Selected remove modal --}}
    <flux:modal name="remove-selected" :dismissible="false" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Remove Selected Students?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to remove all selected students.</p>
                    <p>This action cannot be undone.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="bulkremoveAccount">Remove Students</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Selected inactive modal --}}
    <flux:modal name="inactive-selected" :dismissible="false" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Mark Selected Students as Inactive?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to mark all selected students as inactive.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="bulkmarkInactive">Mark as Inactive</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Selected active modal --}}
    <flux:modal name="active-selected" :dismissible="false" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Mark Selected Students as Active?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to mark all selected students as active.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="amber" wire:click="bulkmarkActive">Mark as Active</flux:button>
            </div>
        </div>
    </flux:modal>

</div>