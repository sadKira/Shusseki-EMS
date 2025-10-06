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

        @if (request()->routeIs(['view_event_timeline']))
            <flux:button variant="ghost" icon="arrow-uturn-left" :href="route('event_timeline')" wire:navigate>Return</flux:button>
        @else
            <flux:button variant="ghost" icon="arrow-uturn-left" :href="route('manage_events')" wire:navigate>Return</flux:button>
        @endif

    </div>


    {{-- Event content --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-2 content-center">
        <!-- Left side -->
        <div class="lg:col-span-3 px-10 py-6 content-center space-y-5">

            {{-- Event Image --}}
            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                class="w-full h-70 object-cover shadow-md">


            {{-- Event stats --}}
            <flux:heading size="lg">Event Statistics</flux:heading>

            @if ($event->status == \App\Enums\EventStatus::Finished)
                <flux:heading class="mb-2 text-white">

                    @if ($totalAttendees > 1)
                        Total Attendees: {{ $totalAttendees }} Students
                    @elseif ($totalAttendees == 0)
                        Total Attendees: {{ $totalAttendees }} Students
                    @else
                        Total Attendees: {{ $totalAttendees }} Student
                    @endif

                </flux:heading>

            @elseif ($event->status == \App\Enums\EventStatus::Postponed)
                <div class="flex items-center gap-2 mb-2">
                    <flux:heading class=" text-white">
                        Total Attendees:
                    </flux:heading>
                    <flux:badge color="red" size="sm" variant="solid">
                        <span class="text-white">Event Postponed</span>
                    </flux:badge>
                </div>
            @else
                <div class="flex items-center gap-2 mb-2">
                    <flux:heading class=" text-white">
                        Total Attendees:
                    </flux:heading>
                    <flux:badge color="zinc" size="sm" variant="solid">
                        <span class="text-white">Event Upcoming</span>
                    </flux:badge>
                </div>
            @endif

            {{-- Progress bar --}}
            <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700">
                @if ($event->status == \App\Enums\EventStatus::Finished)
                    <div class="bg-green-500" style="width: {{ $presentPercentage }}%"></div>
                    <div class="bg-[var(--color-accent)]" style="width: {{ $latePercentage }}%"></div>
                    <div class="bg-red-500" style="width: {{ $absentPercentage }}%"></div>
                @endif
            </div>

            {{-- Legend --}}
            @if ($event->status == \App\Enums\EventStatus::Finished)
                <div class="mt-3 flex items-center justify-between gap-2">
                    <div class="flex items-center space-x-1">
                        <span class="w-3 h-3 bg-green-500 rounded-sm"></span>
                        <flux:text class="text-xs text-white">Present - {{ $presentCount }}</flux:text>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="w-3 h-3 bg-[var(--color-accent)] rounded-sm"></span>
                        <flux:text class="text-xs text-white">Late - {{ $lateCount }}</flux:text>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="w-3 h-3 bg-red-500 rounded-sm"></span>
                        <flux:text class="text-xs text-white">Absent - {{ $absentCount }}</flux:text>
                    </div>
                </div>
            @endif

        </div>

        
        
        <!-- Event Details -->
        <div class="lg:col-span-2 px-10 py-6 flex justify-content">
            <div class="flex items-center gap-x-6">

                <flux:separator class="" vertical />

                {{-- Event details content --}}
                <div class="space-y-3 text-wrap">
                    <flux:text class="mb-4" variant="strong">Academic Year <span class="text-[var(--color-accent)]">{{ $event->school_year }}</span></flux:text>

                    {{-- Title with tag --}}
                    @php
                        $timezone = 'Asia/Manila';
                        $now = \Carbon\Carbon::now()->timezone($timezone);
                        
                        // Combine the actual date with the time strings
                        $start = \Carbon\Carbon::parse($event->date . ' ' . $event->start_time, $timezone);
                        $end = \Carbon\Carbon::parse($event->date . ' ' . $event->end_time, $timezone);
                    @endphp
                    
                    <div class="flex items-center text-pretty gap-2">
                        <flux:heading size="xl">{{ $event->title }}</flux:heading>
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <flux:icon.calendar variant="mini" class="text-zinc-50" />
                        <flux:heading>
                            {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                        </flux:heading>
                    </div>

                    <div class="flex items-center gap-2">
                        <flux:icon.clock variant="mini" class="text-zinc-50" />
                        <flux:heading>
                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - 
                            {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                        </flux:heading>
                    </div>

                    <div class="flex items-center gap-2">
                        <flux:icon.map-pin variant="mini" class="text-zinc-50" />
                        <flux:heading>{{ $event->location }}</flux:heading>
                    </div>

                    <div class="flex items-center gap-2">
                        
                        <flux:icon.exclamation-triangle variant="mini" class="text-zinc-50" />
                        <flux:heading class="flex items-center gap-2">
                            End of Attendace: 
                            <span class="text-[var(--color-accent)]">
                                {{ \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}
                            </span>
                        </flux:heading>
                    </div>

                    <div class="space-y-2 mt-4 max-w-50">
                    
                        <div class="flex items-center justify-between">

                            <flux:heading class="flex items-center">
                                Event Status: 
                            </flux:heading>

                            {{-- Event status --}}
                            <div class="flex items-center">
                                @if ($event->status != \App\Enums\EventStatus::Postponed)
                                    
                                    @if ($event->status != \App\Enums\EventStatus::Finished)         
                                        @if ($now->gt($end))
                                            <flux:badge color="zinc" class="" variant="solid">
                                                <span class="text-white">Untracked</span>
                                            </flux:badge>

                                        @elseif($now->between($start, $end))
                                            <flux:badge color="amber" class="" variant="solid"><span class="text-black">In
                                                Progress</span></flux:badge>
                                        @else
                                            <flux:badge color="zinc" variant="solid">
                                                <span class="text-white">Upcoming</span></flux:badge>
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

                        </div>

                        <div class="flex items-center justify-between">

                            <flux:heading class="flex items-center">
                                Media Coverage: 
                            </flux:heading>

                            <div class="flex items-center">
                                @if ($event->tsuushin_request == \App\Enums\TsuushinRequest::NotApproved)
                                    <flux:badge color="zinc" class="text-white" variant="solid">None</flux:badge>
                                @else
                                    <flux:badge color="green" class="" variant="solid">
                                        <span class="text-black">Available</span></flux:badge>
                                @endif
                            </div>

                        </div>

                    </div>

                    {{-- Admin tools --}}
                    <div class="flex flex-col gap-2 mt-4">

                        @if ($event->status == \App\Enums\EventStatus::Postponed)
                            
                            @can('SA')
                                <flux:modal.trigger name="resume-ev">
                                    <flux:button variant="primary" color="green" icon:trailing="check">Resume Event</flux:button>
                                </flux:modal.trigger>
                                
                                @if (request()->routeIs(['view_event_timeline']))
                                    <flux:button variant="filled" icon:trailing="pencil-square" :href="route('edit_event_timeline', $event)" wire:navigate>Edit Event</flux:button>
                                @else
                                    <flux:button variant="filled" icon:trailing="pencil-square" :href="route('edit_event', $event)" wire:navigate>Edit Event</flux:button>
                                @endif

                            @endcan
                            @can('A')
                                <flux:button variant="filled" icon:trailing="lock-closed" color="amber">Event is Postponed</flux:button>
                                <div class="flex justify-center gap-1 mt-1">
                                    <flux:icon.information-circle class="text-zinc-400" variant="micro" />
                                    <flux:text class="text-xs text-balance">Contact the moderator for further details.</flux:text>
                                </div>
                            @endcan
                        
                        @elseif ($event->status == \App\Enums\EventStatus::NotFinished)
                            
                            <flux:button variant="primary" icon:trailing="arrow-up-right" color="amber" :href="route('attendance_bin_timeline', $event)">View Attendance Bin</flux:button>

                            @can('SA')

                                {{-- <flux:modal.trigger name="send-em">
                                    <flux:button variant="primary" icon:trailing="envelope" color="amber">Send Email Notification</flux:button>
                                </flux:modal.trigger> --}}

                                <div class="flex items-center justify-between gap-2">    
                                    @if (request()->routeIs(['view_event_timeline']))
                                        <flux:button class="w-full" variant="filled" icon:trailing="pencil-square" :href="route('edit_event_timeline', $event)" wire:navigate>Edit Event</flux:button>
                                    @else
                                        <flux:button class="w-full" variant="filled" icon:trailing="pencil-square" :href="route('edit_event', $event)" wire:navigate>Edit Event</flux:button>
                                    @endif
                                
                                    <flux:modal.trigger name="postpone-ev">
                                        <flux:tooltip content="Postpone Event" position="bottom">
                                            <flux:button variant="danger" icon="shield-exclamation"></flux:button>
                                        </flux:tooltip>
                                    </flux:modal.trigger>
                                </div> 
                            @endcan
                            @can('A')
                                @if (request()->routeIs(['view_event_timeline']))
                                    <flux:button class="w-full" variant="filled" icon:trailing="pencil-square" :href="route('edit_event_timeline', $event)" wire:navigate>Edit Event</flux:button>
                                @else
                                    <flux:button class="w-full" variant="filled" icon:trailing="pencil-square" :href="route('edit_event', $event)" wire:navigate>Edit Event</flux:button>
                                @endif
                            @endcan

                        @elseif ($event->status == \App\Enums\EventStatus::Finished)

                            @can('SA')
                                @if ($event->status == \App\Enums\EventStatus::Finished)
                                    <flux:button wire:click="exportAttendanceReport" icon:trailing="folder-arrow-down" variant="primary"
                                            color="amber">Download Record</flux:button>
                                @endif
                                <flux:modal.trigger name="reopen-ab">
                                    <flux:button variant="filled" icon:trailing="lock-open">Reopen Attendance Bin</flux:button>
                                </flux:modal.trigger>
                                <div class="flex justify-center gap-1 mt-1">
                                    <flux:icon.information-circle class="text-zinc-400" variant="micro" />
                                    <flux:text class="text-xs text-balance">Only moderators can reopen the attendance bin.</flux:text>
                                </div>
                            @endcan
                            @can('A')
                                @if ($event->status == \App\Enums\EventStatus::Finished)
                                    <flux:button wire:click="exportAttendanceReport" icon:trailing="folder-arrow-down" variant="primary"
                                            color="amber">Download Record</flux:button>
                                @endif
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
                                        <p class="text-neutral-300">You're about to postpone the event. Postponed events will</p>
                                        <p class="text-neutral-300">prevent access to the attendance bin.</p>
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
                                        <p class="text-neutral-300">You're about to resume the event. Ensure that the</p>
                                        <p class="text-neutral-300">event details are up to date.</p>
                                    </flux:text>
                                </div>
                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button variant="ghost">Cancel</flux:button>
                                    </flux:modal.close>
                                    <flux:button variant="primary" color="green" wire:click="markEventAsResumed">Resume Event</flux:button>
                                </div>
                            </div>
                        </flux:modal>

                        {{-- Reopen AB modal --}}
                        <flux:modal name="reopen-ab" class="min-w-[22rem]">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Reopen Attendance Bin?</flux:heading>
                                    <flux:text class="mt-2">
                                        <p class="text-neutral-300">You're about to reopen the attendance bin. The event will</p>
                                        <p class="text-neutral-300">marked as untracked as long as it is beyond the event date.</p>
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

                        {{-- Reopen AB modal --}}
                        <flux:modal name="send-em" class="min-w-[22rem]">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Send Email?</flux:heading>
                                    <flux:text class="mt-2">
                                        <p class="text-neutral-300">You're lknl</p>
                                        <p class="text-neutral-300">marked as .</p>
                                    </flux:text>
                                </div>
                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button variant="ghost">Cancel</flux:button>
                                    </flux:modal.close>
                                    <flux:button variant="primary" color="amber" wire:click="sendEmailUpdate">Send Email</flux:button>
                                </div>
                            </div>
                        </flux:modal>
                        
                    </div>




                </div>
            </div>
        
        </div>
        
    </div>


</div>