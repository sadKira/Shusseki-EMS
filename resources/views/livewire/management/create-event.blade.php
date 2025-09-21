<div>
    {{-- App Header --}}
    <div class=" relative mb-10 w-full">
        {{-- Breadcrumbs --}}
        <div class="mt-2 flex">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item icon="ellipsis-horizontal" />
                <flux:breadcrumbs.item :href="route('create_event')" :accent="true" wire:navigate>
                    <span class="text-[var(--color-accent)]">Create Event<span>
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <flux:heading size="xl" level="1">Create an Event</flux:heading>
    </div>

    {{-- Centered Form --}}
    <div class="flex justify-center items-center">
        <div class="w-full max-w-5xl rounded-xl metallic-card-soft shadow-lg">
            <div class="px-10 py-8">
                {{-- Create event form --}}
                <form wire:submit.prevent="createEvent">
                    @csrf
                    <flux:fieldset>
                        <flux:legend class="text-lg font-semibold mb-4">Create an Event</flux:legend>

                        <div class="space-y-8">
                            <div class="grid grid-cols-12 gap-8">

                                {{-- Left Column --}}
                                <div class="col-span-7 space-y-6">
                                    <div class="grid grid-cols-6 gap-5">
                                        <div class="col-span-3">
                                            <flux:input wire:model="title" label="Title" type="text" required autofocus
                                                placeholder="Event title" clearable autocomplete="off" />
                                        </div>

                                        <div class="col-span-3">
                                            <flux:input wire:model="location" label="Location" icon="map-pin"
                                                type="text" required placeholder="Event location" clearable
                                                autocomplete="off" />
                                        </div>

                                        <div class="col-span-3">
                                            <flux:input wire:model="date" label="Event Date" type="text" id="datepicker"
                                                placeholder="e.g. July 12, 2000" autocomplete="off" />
                                        </div>

                                        <div class="col-span-3">
                                            <div class="flex items-start gap-1">
                                                <flux:input id="tp_input_time_in" wire:model="time_in"
                                                    placeholder="Select Time" label="End of Attendance"
                                                    type="text" mask="99:99 aa" required autocomplete="off" readonly />
                                                <x-time-picker-time-in />
                                            </div>
                                        </div>

                                        <div class="col-span-3">
                                            <div class="flex items-start gap-1">
                                                <flux:input id="tp_input" wire:model="start_time"
                                                    placeholder="Select Start Time" label="Start Time" type="text"
                                                    mask="99:99 aa" required autocomplete="off" readonly />
                                                <x-time-picker />
                                            </div>
                                        </div>

                                        <div class="col-span-3">
                                            <div class="flex items-start gap-1">
                                                <flux:input id="tp_input_2" wire:model="end_time"
                                                    placeholder="Select End Time" label="End Time" type="text"
                                                    mask="99:99 aa" required autocomplete="off" readonly />
                                                <x-time-picker-2 />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Right Column --}}
                                <div class="col-span-5 p-6 flex flex-col justify-center">
                                    <flux:input type="file" wire:model="image" badge="Required"
                                        label="Upload Event Image" />
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="flex gap-5">
                                <flux:button type="submit" variant="primary" class="w-full">
                                    {{ __('Create Event') }}
                                </flux:button>
                                <flux:button variant="filled" wire:navigate href="{{ route('event_timeline') }}"
                                    class="w-full">
                                    {{ __('Cancel') }}
                                </flux:button>
                            </div>
                        </div>
                    </flux:fieldset>
                </form>
            </div>
        </div>
    </div>



</div>