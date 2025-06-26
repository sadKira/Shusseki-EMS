<div>
    <div class="mt-5 flex items-center justify-between max-lg:hidden">
        <div class="flex items-center space-x-1">

            {{-- Active and inactive students filter --}}
            <flux:dropdown>
                <flux:button variant="filled" icon:trailing="chevron-down">{{ $selectedStatus }}</flux:button>
                <flux:menu>
                    <flux:menu.radio.group>
                        <flux:menu.radio checked wire:click="$set('selectedStatus', 'Active Students')">Active Students
                        </flux:menu.radio>
                        <flux:menu.radio wire:click="$set('selectedStatus', 'Inactive Students')">Inactive Students
                        </flux:menu.radio>
                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>

        </div>

        <div class="flex items-cent gap-2">
            <flux:input icon="magnifying-glass" placeholder="Search..." />
        </div>
    </div>

    
   
    
    {{-- Table --}}
    <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
        <flux:checkbox.group>
            <table class="w-full text-sm text-left rtl:text-right text-zinc-600 dark:text-zinc-400">
                <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300">
                    <tr>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap p-3 cursor-pointer" wire:click="sortBy('name')">
                            <div class="class flex items-center gap-2">
                                Student Name
                                @if ($sortField === 'name')
                                    @if ($sortDirection === 'asc')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                                        </svg>

                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
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
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }} "
                            class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700 border-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                            <th scope="row" class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-zinc-100">
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
                                    <flux:button variant="primary" color="Amber" wire:click="markInactive({{ $user->id }})">
                                    Mark as Inactive</flux:button>
                                @else
                                <flux:button variant="primary" color="Amber" wire:click="markActive({{ $user->id }})">
                                    Mark as Active</flux:button>
                                <flux:button variant="danger" wire:confirm="Confirm account removal." wire:click="removeAccount({{ $user->id }})">
                                    Remove Account</flux:button>
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