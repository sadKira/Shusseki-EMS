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
        <div class="whitespace-nowrap grid justify-items-center px-7 py-6">
            <flux:text>Pending Approval</flux:text>
            {{-- <flux:icon.user-group class="text-zinc-50" variant="solid" /> --}}
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

        {{-- Content Main --}}
        <div class="metallic-card-soft rounded-xl px-7 py-6">
 
            {{-- Selection --}}
            <div class="flex items-center justify-between">

                <flux:input class="max-w-xs" icon="magnifying-glass" placeholder="Search..."  wire:model.live.debounce.150ms="search" autocomplete="off" clearable/>

                <div class="flex items-center">
                    {{-- Selection Count Button --}}
                    <flux:button icon="x-mark" variant="filled" wire:click="cancelSelection"
                        class="{{ count($selected) > 0 ? 'opacity-100' : 'opacity-0 pointer-events-none' }}">
                        {{ count($selected) }} selected
                    </flux:button>

                    {{-- Bulk Buttons Container --}}
                    <div class="ml-3 {{ $pendingCount > 1 ? 'opacity-100' : 'opacity-0 pointer-events-none' }}">
                        <flux:dropdown position="bottom" align="end">
                            <flux:button icon:trailing="chevron-down" variant="primary" color="amber">Bulk Actions
                            </flux:button>
                            <flux:menu>
                                @if (count($selected) > 0)

                                    {{-- Selected actions --}}
                                    <flux:modal.trigger name="selected-approve">
                                        <flux:menu.item icon="check">Approve Selected Accounts</flux:menu.item>
                                    </flux:modal.trigger>

                                    <flux:modal.trigger name="selected-reject">
                                        <flux:menu.item icon="x-mark" variant="danger">Reject Selected Accounts</flux:menu.item>
                                    </flux:modal.trigger>

                                @endif
                                @if (count($selected) > 0)
                                @else

                                    {{-- Bulk actions --}}
                                    <flux:modal.trigger name="bulk-approve">
                                        <flux:menu.item icon="check-badge">Approve All Pending Accounts</flux:menu.item>
                                    </flux:modal.trigger>

                                    <flux:modal.trigger name="bulk-reject">
                                        <flux:menu.item icon="trash" variant="danger">Reject All Pending Accounts
                                        </flux:menu.item>
                                    </flux:modal.trigger>

                                @endif

                            </flux:menu>
                        </flux:dropdown>
                    </div>
                </div>

            </div>

            {{-- Table --}}
            <div class="flex flex-col mt-5">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden rounded-xl">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                <thead class="">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            Student Name</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            ID</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            Email</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            Year Level</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            Course</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            Action</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                    @forelse ($users as $user)
                                        <tr wire:key="user-{{ $user->id }}" class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                @if ($pendingCount > 1)
                                                    <div class="flex items-center">
                                                        <flux:checkbox value="{{ $user->id }}" wire:model.live="selected" />
                                                    </div>
                                                @endif
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                                                {!! $user->highlightField('name', $search) !!}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                {!! $user->highlightField('student_id', $search) !!}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                {!! $user->highlightField('email', $search) !!}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                {!! $user->highlightField('year_level', $search) !!}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                @php
                                                    
                                                    $course = $user->course;

                                                    $output = match(true) {
                                                        $course == 'Bachelor of Arts in International Studies' => 'ABIS',
                                                        $course == 'Bachelor of Science in Information Systems' => 'BSIS',
                                                        $course == 'Bachelor of Human Services' => 'BHS',
                                                        $course == 'Bachelor of Secondary Education' => 'BSED',
                                                        default => 'Course',
                                                    };

                                                @endphp
                                                {!! $user->highlightText($output, $search) !!}
                                            </td>
                                            <td class="px-6 py-4 flex justify-center">
                                                {{-- <button type="button"
                                                    class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">Delete</button> --}}

                                                <flux:dropdown position="left" align="end">
                                                    <flux:button variant="filled" size="xs" icon="ellipsis-horizontal"></flux:button>
                                                    <flux:menu>

                                                        <flux:modal.trigger :name="'approve-solo-'.$user->id">
                                                            <flux:menu.item icon="check">
                                                                Approve</flux:menu.item>
                                                        </flux:modal.trigger>

                                                        <flux:modal.trigger :name="'reject-solo-'.$user->id">
                                                            <flux:menu.item icon="x-mark" variant="danger">
                                                                Reject</flux:menu.item>
                                                        </flux:modal.trigger>

                                                    </flux:menu>
                                                </flux:dropdown>

                                                {{-- Approve modal --}}
                                                <flux:modal :name="'approve-solo-'.$user->id" :dismissible="false"
                                                    class="min-w-[22rem]">
                                                    <div class="space-y-6">
                                                        <div>
                                                            <flux:heading size="lg">Approve User?</flux:heading>
                                                            <flux:text class="mt-2">
                                                                <p>You're about to approve {{ $user->name }}.</p>
                                                            </flux:text>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <flux:spacer />
                                                            <flux:modal.close>
                                                                <flux:button variant="ghost">Cancel</flux:button>
                                                            </flux:modal.close>
                                                            <flux:button variant="primary" color="amber"
                                                                wire:click="approve({{ $user->id }})">Approve User</flux:button>
                                                        </div>
                                                    </div>
                                                </flux:modal>

                                                {{-- Reject modal --}}
                                                <flux:modal :name="'reject-solo-'.$user->id" :dismissible="false"
                                                    class="min-w-[22rem]">
                                                    <div class="space-y-6">
                                                        <div>
                                                            <flux:heading size="lg">Reject User?</flux:heading>
                                                            <flux:text class="mt-2">
                                                                <p>You're about to reject {{ $user->name }}.</p>
                                                            </flux:text>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <flux:spacer />
                                                            <flux:modal.close>
                                                                <flux:button variant="ghost">Cancel</flux:button>
                                                            </flux:modal.close>
                                                            <flux:button variant="danger" wire:click="reject({{ $user->id }})">
                                                                Reject User</flux:button>
                                                        </div>
                                                    </div>
                                                </flux:modal>

                                            </td>
                                        </tr>       
                                    @empty
                                        <tr class="">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm  text-gray-800 dark:text-neutral-200">
                                                <div class="flex justify-center items-center gap-2 w-full">
                                                    <flux:icon.user-circle variant="solid" class="text-zinc-50" />
                                                    <flux:heading size="lg">No Pending Accounts</flux:heading>
                                                </div>
                                            </td>
                                        </tr> 
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    {{-- Bulk Approve modal --}}
    <flux:modal name="bulk-approve" class="min-w-[22rem]" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Approve All Pending Users?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to approve all pending users.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="amber" wire:click="totalbulkApprove">Approve All</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Bulk Reject modal --}}
    <flux:modal name="bulk-reject" class="min-w-[22rem]" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Reject All Pending Users?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to reject all pending users.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="totalbulkReject">Reject All</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Approve Selected modal --}}
    <flux:modal name="selected-approve" class="min-w-[22rem]" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Approve Selected Pending Users?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to approve all selected pending users.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="amber" wire:click="bulkApprove">Approve Selected</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Reject selected modal --}}
    <flux:modal name="selected-reject" class="min-w-[22rem]" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Reject Selected Pending Users?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to reject all selected pending users.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" wire:click="bulkReject">Reject Selected</flux:button>
            </div>
        </div>
    </flux:modal>
</div>