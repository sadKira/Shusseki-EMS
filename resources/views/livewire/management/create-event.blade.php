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

    {{-- Form --}}
    <div class="w-full rounded-xl bg-white dark:bg-(--import) dark:border-stone-800 text-stone-800 shadow-xs">
        <div class="px-20 py-8">
            <form wire:submit.prevent="createEvent">
                @csrf
                <flux:fieldset>
                    <flux:legend>Create an Event</flux:legend>

                    <div class="space-y-6">
                        <div class="flex items-start space gap-x-6">
                            <div class="grid grid-cols-6 gap-x-5 gap-y-6 w-full">

                                <div class="col-span-3">
                                    <!-- Event title -->
                                    <flux:input wire:model="title" label="Title" type="text" required autofocus
                                        placeholder="Event title" clearable />
                                </div>

                                <div class="col-span-3">
                                    {{-- Location --}}
                                    <flux:input wire:model="location" label="Location" icon="map-pin" type="text"
                                        required placeholder="Event location" />
                                </div>

                                <div class="col-span-3">
                                    {{-- Date --}}
                                    <flux:input wire:model="date" label="Event Date" type="text" id="datepicker"
                                        required placeholder="" />
                                </div>

                                <div class="col-span-3">
                                    {{-- Tag --}}
                                    <flux:select wire:model.lazy="tag" label="Select Event Tag"
                                        placeholder="Select tag">
                                        <flux:select.option value="">Select Event Tag</flux:select.option>
                                        @foreach($tags as $tag)
                                            <flux:select.option value="{{ $tag->value }}">{{ $tag->label() }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </div>

                                <div class="col-span-3">
                                    {{-- Start time --}}
                                    <div class="flex items-center gap-1">
                                        <flux:input id="tp_input" wire:model="start_time" label="Start Time" type="text" required placeholder="hh:mm aa" />
                                        <x-time-picker/>
                                    </div>
                                      
                                </div>

                                <div class="col-span-3">
                                    {{-- End time --}}
                                    <div class="flex items-center gap-1">
                                        <flux:input id="tp_input_2" wire:model="end_time" label="End Time" type="text" required placeholder="Select time"/>
                                        <x-time-picker-2 />
                                    </div>
                                </div>

                                <div class="col-span-6">
                                    {{-- Event image --}}
                                    <flux:input type="file" wire:model="image" badge="Required"
                                        label="Upload Event Image" />
                                </div>
                            </div>
                            <!-- Separator -->
                            <flux:separator vertical />

                            <!-- Right column -->
                            <div class="w-full gap-y-6 grid grid-cols-6">
                                <div class="col-span-6">
                                    <flux:textarea label="Description" wire:model="description" required
                                        placeholder="Say something about the event" resize="none" rows="auto" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center">
                            <flux:button type="submit" variant="primary" class="w-full">
                                {{ __('Create account') }}
                            </flux:button>
                        </div>
                    </div>


                </flux:fieldset>

            </form>

        </div>
    </div>




    @section('scripts')
        <script>
            function initDatePicker() {
                const field = document.getElementById('datepicker');
                if (!field || field.dataset.pikaday === 'initialized') return;

                const { DateTime } = luxon;

                const picker = new Pikaday({
                    field,
                    onSelect: function (date) {
                        const luxonDate = DateTime.fromJSDate(date);
                        field.value = luxonDate.toFormat('LLLL dd, yyyy');
                    }
                });

                field.dataset.pikaday = 'initialized';
            }

        </script>
        {{-- <script>
            window.HSStaticMethods.autoInit();
        </script> --}}
    @endsection


</div>