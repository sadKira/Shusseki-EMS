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
    <div class=" px-50 flex flex-col justify-center">

        <div class="rounded-xl bg-white dark:bg-(--import) dark:border-stone-800 text-stone-800 shadow-xs">
            <div class="px-20 py-8">
                <form class="flex items-center gap-6">
                    @csrf

                    <div class="flex flex-col justify-center gap-6 w-full">
                        <!-- Event title -->
                        <flux:input label="Event Title" type="text" required autofocus placeholder="Event title" />

                        <!-- Description -->
                        <flux:textarea label="Event Description" required placeholder="Say something about the event"
                            resize="none" rows="auto" />

                        {{-- Date --}}
                        <flux:input label="Event Date" type="text" id="datepicker" required autofocus placeholder="" />



                        <div class="flex items-center justify-end">
                            <flux:button type="submit" variant="primary" class="w-full">
                                {{ __('Create account') }}
                            </flux:button>
                        </div>
                    </div>

                </form>

            </div>
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
    @endsection


</div>