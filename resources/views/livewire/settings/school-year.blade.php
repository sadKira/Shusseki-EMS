<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Academic Year')" :subheading="__('Set and append an academic year')">
        
    <div class="flex items-center gap-3 mt-10">

        <flux:heading>Current Academic Year</flux:heading>

        <flux:dropdown>
            <flux:button variant="filled" icon:trailing="chevron-down">A.Y. {{ $selectedSchoolYear }}</flux:button>
            <flux:menu>
                <flux:menu.radio.group wire:model.live="selectedSchoolYear">
                    @foreach ($schoolYears as $year)
                        <flux:menu.radio value="{{ $year }}">{{ $year }}</flux:menu.radio>
                    @endforeach
                </flux:menu.radio.group>
            </flux:menu>
        </flux:dropdown>

    </div>
    <div class="mt-10 flex justify-start">

        <form wire:submit="addSchoolYear" class="flex flex-col justify-start gap-4">

            <flux:input 
                wire:model="newSchoolYear"
                label="Append an Academic Year" 
                badge="e.g. 2025-2026"
                description="Create and append an academic year."
                mask="9999-9999"
                placeholder="yyyy-yyyy"
                />

            <flux:modal.trigger name="add-year">
                <flux:button variant="primary" class="w-full">{{ __('Append') }}</flux:button>
            </flux:modal.trigger>
            

            <flux:modal name="add-year" class="min-w-[22rem]">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Add Academic Year?</flux:heading>

                        <flux:text class="mt-2">
                            <p>You're about to append to the list of academic</p>
                            <p>years. Deleting a year is not possible. Ensure</p>
                            <p>that your input is correct.</p>
                        </flux:text>
                    </div>

                    <div class="flex gap-2">
                        <flux:spacer />

                        <flux:modal.close>
                            <flux:button variant="ghost">Cancel</flux:button>
                        </flux:modal.close>
                        
                        <flux:modal.close>
                            <flux:button type="submit" variant="primary" color="amber">Append Year</flux:button>
                        </flux:modal.close>
                    </div>
                </div>
            </flux:modal>

        </form>

    </div>


    </x-settings.layout>
</section>
