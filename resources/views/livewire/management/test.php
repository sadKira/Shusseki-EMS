@if ($selectedStatus == 'Active Students')
                {{-- Year level filter --}}
                <flux:dropdown>
                    <flux:button variant="ghost" icon:trailing="chevron-down">{{ $selectedStatus_level }}</flux:button>
                    <flux:menu>
                        <flux:menu.radio.group>
                            <flux:menu.radio checked wire:click="selectYear('All')">All</flux:menu.radio>
                            <flux:menu.radio wire:click="selectYear('1st Year')">1st Year</flux:menu.radio>
                            <flux:menu.radio wire:click="selectYear('2nd Year')">2nd Year</flux:menu.radio>
                            <flux:menu.radio wire:click="selectYear('3rd Year')">3rd Year</flux:menu.radio>
                            <flux:menu.radio wire:click="selectYear('4th Year')">4th Year</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>

                {{-- Course filter --}}
                <flux:dropdown>
                    <flux:button variant="ghost" icon:trailing="chevron-down">{{ $selectedStatus_course }}</flux:button>
                    <flux:menu>
                        <flux:menu.radio.group>
                            <flux:menu.radio checked wire:click="selectCourse('All')">All</flux:menu.radio>
                            <flux:menu.radio wire:click="selectCourse('Bachelor of Arts in International Studies')">
                                Bachelor of Arts in International Studies</flux:menu.radio>
                            <flux:menu.radio wire:click="selectCourse('Bachelor of Science in Information Systems')">
                                Bachelor of Science in Information Systems</flux:menu.radio>
                            <flux:menu.radio wire:click="selectCourse('Bachelor of Human Services')">
                                Bachelor of Human Services</flux:menu.radio>
                            <flux:menu.radio wire:click="selectCourse('Bachelor of Secondary Education')">
                                Bachelor of Secondary Education</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>
             @endif
            








            {{-- Mobile view (A and I filter) --}}
    <div class="mt-5 relative justify-between lg:hidden">
        <div class="flex items-center space-x-1">

            {{-- Active and inactive students filter --}}
            <flux:dropdown>
                <flux:button variant="filled" icon:trailing="chevron-down">{{ $selectedStatus }}</flux:button>
                <flux:menu>
                    <flux:menu.radio.group>
                        <flux:menu.radio checked wire:click="selectStatus('Active Students')">Active Students
                        </flux:menu.radio>
                        <flux:menu.radio wire:click="selectStatus('Inactive Students')">Inactive Students
                        </flux:menu.radio>
                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>
            
        </div>
        <div class="mt-5"> 
            <flux:input icon="magnifying-glass" placeholder="Search..." />
        </div>
    </div>


    @if ($selectedStatus == 'Active Students')
                {{-- Yearl level filter --}}
                <flux:dropdown>
                    <flux:button variant="ghost" icon:trailing="chevron-down">{{ $selectedStatus_level }}</flux:button>
                    <flux:menu>
                        <flux:menu.radio.group>
                            <flux:menu.radio checked wire:click="$set('selectedStatus_level', 'All')">All</flux:menu.radio>
                            <flux:menu.radio wire:click="$set('selectedStatus_level', '1st Year')">1st Year</flux:menu.radio>
                            <flux:menu.radio wire:click="$set('selectedStatus_level', '2nd Year')">2nd Year</flux:menu.radio>
                            <flux:menu.radio wire:click="$set('selectedStatus_level', '3rd Year')">3rd Year</flux:menu.radio>
                            <flux:menu.radio wire:click="$set('selectedStatus_level', '4th Year')">4th Year</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>

                {{-- Course filter --}}
                <flux:dropdown>
                    <flux:button variant="ghost" icon:trailing="chevron-down">{{ $selectedStatus_course }}</flux:button>
                    <flux:menu>
                        <flux:menu.radio.group>
                            <flux:menu.radio checked wire:click="$set('selectedStatus_course', 'All')">All</flux:menu.radio>
                            <flux:menu.radio wire:click="$set('selectedStatus_course', 'Bachelor of Arts in International Studies')">
                                Bachelor of Arts in International Studies</flux:menu.radio>
                            <flux:menu.radio wire:click="$set('selectedStatus_course', 'Bachelor of Science in Information Systems')">
                                Bachelor of Science in Information Systems</flux:menu.radio>
                            <flux:menu.radio wire:click="$set('selectedStatus_course', 'Bachelor of Human Services')">
                                Bachelor of Human Services</flux:menu.radio>
                            <flux:menu.radio wire:click="$set('selectedStatus_course', 'Bachelor of Secondary Education')">
                                Bachelor of Secondary Education</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>
            @endif 