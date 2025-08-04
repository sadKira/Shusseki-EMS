<div>
    <div class="flex flex-col gap-6">

        {{-- Sub Headings --}}
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <flux:heading size="xl" level="1">200 Users</flux:heading>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                    <flux:heading size="l" level="1">20 Active</flux:heading>
                </div>

                <flux:separator vertical />

                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                    </svg>
                    <flux:heading size="l" level="1">5 Inactive</flux:heading>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="flex items-center justify-between flex-wrap gap-4 max-lg:hidden">

            {{-- Filter Group --}}
            <div class="flex items-center flex-wrap gap-3">

                {{-- Active/Inactive Filter --}}
                <flux:dropdown>
                    <flux:button variant="primary" color="amber" icon:trailing="chevron-down" size="sm">
                        {{ $selectedStatus }}
                    </flux:button>
                    <flux:menu>
                        <flux:menu.radio.group wire:model.live="selectedStatus">
                            <flux:menu.radio checked value="Active Accounts">Active Accounts</flux:menu.radio>
                            <flux:menu.radio value="Inactive Accounts">Inactive Accounts</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>

                {{-- Conditional Filters --}}
                @if ($selectedStatus == 'Active Accounts')
                    <div class="flex items-center gap-2">
                        <flux:text class="text-xs" variant="strong">Year Level:</flux:text>
                        <flux:dropdown>
                            <flux:button variant="ghost" icon:trailing="chevron-down" size="sm">
                                {{ $selectedStatus_level }}
                            </flux:button>
                            <flux:menu>
                                <flux:menu.radio.group wire:model.live="selectedStatus_level">
                                    <flux:menu.radio checked value="All">All</flux:menu.radio>
                                    <flux:menu.radio value="1st Year">1st Year</flux:menu.radio>
                                    <flux:menu.radio value="2nd Year">2nd Year</flux:menu.radio>
                                    <flux:menu.radio value="3rd Year">3rd Year</flux:menu.radio>
                                    <flux:menu.radio value="4th Year">4th Year</flux:menu.radio>
                                </flux:menu.radio.group>
                            </flux:menu>
                        </flux:dropdown>
                    </div>

                    <div class="flex items-center gap-2">
                        <flux:text class="text-xs" variant="strong">Course:</flux:text>
                        <flux:dropdown>
                            <flux:button variant="ghost" icon:trailing="chevron-down" size="sm">
                                {{ $selectedStatus_course }}
                            </flux:button>
                            <flux:menu>
                                <flux:menu.radio.group wire:model.live="selectedStatus_course">
                                    <flux:menu.radio checked value="All">All</flux:menu.radio>
                                    <flux:menu.radio value="Bachelor of Arts in International Studies">Bachelor of Arts in International Studies</flux:menu.radio>
                                    <flux:menu.radio value="Bachelor of Science in Information Systems">Bachelor of Science in Information Systems</flux:menu.radio>
                                    <flux:menu.radio value="Bachelor of Human Services">Bachelor of Human Services</flux:menu.radio>
                                    <flux:menu.radio value="Bachelor of Secondary Education">Bachelor of Secondary Education</flux:menu.radio>
                                </flux:menu.radio.group>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                @endif

                {{-- Clear Filters --}}
                @if ($selectedStatus_level !== 'All' || $selectedStatus_course !== 'All' || $search !== '')
                    <flux:button variant="primary" icon="x-mark" wire:click="clearFilters" color="red" size="sm">
                        Clear Filters
                    </flux:button>
                @endif
            </div>

            {{-- Search --}}
            <div class="flex items-center">
                <flux:input icon="magnifying-glass" placeholder="Search..." wire:model.live.debounce.300ms="search" />
            </div>
        </div>

        {{-- Mobile Filters --}}
        <div class="lg:hidden flex flex-col gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <flux:dropdown>
                    <flux:button variant="primary" color="amber" size="sm" icon:trailing="chevron-down">
                        {{ $selectedStatus }}
                    </flux:button>
                    <flux:menu>
                        <flux:menu.radio.group wire:model.live="selectedStatus">
                            <flux:menu.radio checked value="Active Accounts">Active Accounts</flux:menu.radio>
                            <flux:menu.radio value="Inactive Accounts">Inactive Accounts</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>

                @if ($selectedStatus_level !== 'All' || $selectedStatus_course !== 'All' || $search !== '')
                    <flux:button variant="primary" icon="x-mark" wire:click="clearFilters" color="red" size="sm">
                        Clear Filters
                    </flux:button>
                @endif
            </div>

            @if ($selectedStatus == 'Active Accounts')
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <flux:text class="text-xs" variant="strong">Year Level:</flux:text>
                        <flux:dropdown>
                            <flux:button variant="ghost" icon:trailing="chevron-down">
                                {{ $selectedStatus_level }}
                            </flux:button>
                            <flux:menu>
                                <flux:menu.radio.group wire:model.live="selectedStatus_level">
                                    <flux:menu.radio checked value="All">All</flux:menu.radio>
                                    <flux:menu.radio value="1st Year">1st Year</flux:menu.radio>
                                    <flux:menu.radio value="2nd Year">2nd Year</flux:menu.radio>
                                    <flux:menu.radio value="3rd Year">3rd Year</flux:menu.radio>
                                    <flux:menu.radio value="4th Year">4th Year</flux:menu.radio>
                                </flux:menu.radio.group>
                            </flux:menu>
                        </flux:dropdown>
                    </div>

                    <div class="flex items-center gap-2">
                        <flux:text class="text-xs" variant="strong">Course:</flux:text>
                        <flux:dropdown>
                            <flux:button variant="ghost" icon:trailing="chevron-down">
                                {{ $selectedStatus_course }}
                            </flux:button>
                            <flux:menu>
                                <flux:menu.radio.group wire:model.live="selectedStatus_course">
                                    <flux:menu.radio checked value="All">All</flux:menu.radio>
                                    <flux:menu.radio value="Bachelor of Arts in International Studies">Bachelor of Arts in International Studies</flux:menu.radio>
                                    <flux:menu.radio value="Bachelor of Science in Information Systems">Bachelor of Science in Information Systems</flux:menu.radio>
                                    <flux:menu.radio value="Bachelor of Human Services">Bachelor of Human Services</flux:menu.radio>
                                    <flux:menu.radio value="Bachelor of Secondary Education">Bachelor of Secondary Education</flux:menu.radio>
                                </flux:menu.radio.group>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                </div>
            @endif

            <div>
                <flux:input icon="magnifying-glass" placeholder="Search..." wire:model.live.debounce.300ms="search" />
            </div>
        </div>

        {{-- Table and Pagination stay as-is --}}
    </div>
</div>
