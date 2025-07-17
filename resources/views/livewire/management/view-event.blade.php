<div>
    {{-- App Header --}}
    <div class=" relative mb-10 w-full">
        {{-- Breadcrumbs
        <div class="mt-2 flex">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item icon="ellipsis-horizontal" />
                <flux:breadcrumbs.item :href="route('view_event', $event)" :accent="true" wire:navigate>
                    <span class="text-[var(--color-accent)]">View Event<span>
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <flux:heading size="xl" level="1">View Event</flux:heading> --}}
        <flux:button variant="ghost" icon="arrow-uturn-left" :href="route('manage_events')" wire:navigate>Return</flux:button>
    </div>


    {{-- Event content --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-7">
        <!-- Event Image -->
        <div class="lg:col-span-3 px-10 py-6">
            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                class="w-full h-70 object-cover shadow-md">
        </div>

        
        
        <!-- Event Details -->
        <div class="lg:col-span-2 px-10 py-6 flex justify-content">
            <div class="flex items-center gap-x-6">

                <flux:separator class="my-4" vertical />

                {{-- Event details content --}}
                <div class="space-y-3 text-balance">
                    <flux:text class="mb-4" variant="strong">Academic Year <span class="text-[var(--color-accent)]">{{ $event->school_year }}</span></flux:text>

                    {{-- Title with tag --}}
                    @php
                        $timezone = 'Asia/Manila';
                        $now = \Carbon\Carbon::now()->timezone($timezone);
                        
                        // Combine the actual date with the time strings
                        $start = \Carbon\Carbon::parse($event->date . ' ' . $event->start_time, $timezone);
                        $end = \Carbon\Carbon::parse($event->date . ' ' . $event->end_time, $timezone);
                    @endphp
                    
                    <div class="flex items-center gap-2">
                        <flux:heading size="xl">{{ $event->title }}</flux:heading>

                        {{-- Event status --}}
                        @if ($event->status != \App\Enums\EventStatus::Postponed)
                            @if ($now->between($start, $end))
                                <flux:badge color="amber" class="" variant="solid"><span class="text-black">In
                                        Progress</span></flux:badge>
                            @endif
                            @if ($event->status != \App\Enums\EventStatus::Finished)         
                                @if ($now->gt($end))
                                    <flux:badge color="zinc" class="" variant="solid">
                                        <span class="text-white">Untracked</span>
                                    </flux:badge>
                                @endif
                            @endif
                        @endif
                        @if ($event->status == \App\Enums\EventStatus::Finished)
                            <flux:badge color="green" class="" variant="solid"><span
                                    class="text-black">Ended</span></flux:badge>
                        @endif
                        @if ($event->status == \App\Enums\EventStatus::Postponed)
                            <flux:badge color="red" class="" variant="solid"><span
                                    class="text-white">Postponed</span></flux:badge>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <flux:icon.calendar class="text-zinc-50" />
                        <flux:heading>
                            {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}, 
                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - 
                            {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                        </flux:heading>
                    </div>

                    <div class="flex items-center gap-2">
                        <flux:icon.map-pin class="text-zinc-50" />
                        <flux:heading>{{ $event->location }}</flux:heading>
                    </div>
                    

                    <flux:heading class="flex items-center gap-2 mt-4">
                        End of Time In Period: <span class="text-[var(--color-accent)]">{{ \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}</span>

                        <flux:tooltip position="bottom" toggleable>
                            <flux:button icon="information-circle" variant="ghost" />
                            <flux:tooltip.content class="max-w-[20rem] space-y-2">
                                <p>Students are expected to scan their</p>
                                <p>QR codes before the end of the time in period.</p>
                            </flux:tooltip.content>
                        </flux:tooltip>
                    </flux:heading>
                </div>
            </div>
        
        </div>
        
        <!-- Event Description -->
        <div class="lg:col-span-3 px-10 py-4 text-balance break-words break-all">
            <flux:heading size="xl" class="">Event <span class="text-[var(--color-accent)]">Description</span></flux:heading>
            <flux:separator class="mt-2" />
            <flux:text class="text-base leading-relaxed mt-4 text-zinc-50">{{ $event->description }}</flux:text>
        </div>

        <!-- Admin Tools -->
        <div class="lg:col-span-2 px-10 py-4">
            <div class="flex flex-col gap-2">

                @if ($event->status == \App\Enums\EventStatus::Postponed)
                    
                    @can('SA')
                        <flux:modal.trigger name="resume-ev">
                            <flux:button variant="primary" color="green" icon:trailing="check">Resume Event</flux:button>
                        </flux:modal.trigger>
                        <flux:button variant="filled" icon:trailing="pencil-square" :href="route('edit_event', $event)" wire:navigate>Edit Event</flux:button>
                    @endcan
                    @can('A')
                        <flux:button variant="filled" icon:trailing="lock-closed" color="amber">Event is Postponed</flux:button>
                        <div class="flex justify-center gap-1 mt-1">
                            <flux:icon.information-circle class="text-zinc-400" variant="micro" />
                            <flux:text class="text-xs text-balance">Contact the moderator for further details.</flux:text>
                        </div>
                    @endcan
                
                @elseif ($event->status == \App\Enums\EventStatus::NotFinished)

                    <flux:button variant="primary" icon:trailing="arrow-up-right" color="amber" :href="route('attendance_bin', $event)">View Attendance Bin</flux:button>
                    <flux:button variant="filled" icon:trailing="pencil-square" :href="route('edit_event', $event)" wire:navigate>Edit Event</flux:button>

                    @can('SA')
                        <flux:modal.trigger name="postpone-ev">
                            <flux:button variant="danger" icon:trailing="shield-exclamation">Postpone Event</flux:button>
                        </flux:modal.trigger>
                    @endcan

                @elseif ($event->status == \App\Enums\EventStatus::Finished)

                    @can('SA')
                        <flux:modal.trigger name="reopen-ab">
                            <flux:button variant="primary" icon:trailing="lock-open" color="amber">Reopen Attendance Bin</flux:button>
                        </flux:modal.trigger>
                        <div class="flex justify-center gap-1 mt-1">
                            <flux:icon.information-circle class="text-zinc-400" variant="micro" />
                            <flux:text class="text-xs text-balance">Only moderators can reopen the attendance bin.</flux:text>
                        </div>
                    @endcan
                    @can('A')
                        <flux:button variant="filled" icon:trailing="lock-closed" color="amber">Attendance Bin Closed</flux:button>
                        <div class="flex justify-center gap-1 mt-1">
                            <flux:icon.information-circle class="text-zinc-400" variant="micro" />
                            <flux:text class="text-xs text-balance">Contact the moderator to reopen the bin.</flux:text>
                        </div>
                    @endcan

                @endif

                {{-- Postpone event modal --}}
                <flux:modal name="postpone-ev" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Postpone Event?</flux:heading>
                            <flux:text class="mt-2">
                                <p>You're about to postpone the event. Postponed events will</p>
                                <p>prevent access to the attendance bin.</p>
                            </flux:text>
                        </div>
                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button variant="danger" wire:click="markEventAsPostponed">Postpone Event</flux:button>
                        </div>
                    </div>
                </flux:modal>

                {{-- Resume event modal --}}
                <flux:modal name="resume-ev" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Resume Event?</flux:heading>
                            <flux:text class="mt-2">
                                <p>You're about to resume the event. Ensure that the</p>
                                <p>event details are up to date.</p>
                            </flux:text>
                        </div>
                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button variant="primary" color="amber" wire:click="markEventAsResumed">Resume Event</flux:button>
                        </div>
                    </div>
                </flux:modal>

                {{-- Reopen AB modal --}}
                <flux:modal name="reopen-ab" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Reopen Attendance Bin?</flux:heading>
                            <flux:text class="mt-2">
                                <p>You're about to reopen the attendance bin. The event will</p>
                                <p>marked as untracked as long as it is beyond the event date.</p>
                            </flux:text>
                        </div>
                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button variant="primary" color="amber" wire:click="markEventAsResumed">Reopen Bin</flux:button>
                        </div>
                    </div>
                </flux:modal>
            </div>
        </div>
    </div>


</div>