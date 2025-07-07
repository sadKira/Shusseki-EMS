<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Super and Admin Dashboard') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Shusseki Events Management System') }}</flux:subheading>
        <flux:separator variant="subtle" />

        <flux:dropdown>
            <flux:button variant="filled" icon:trailing="chevron-down">A.Y. {{ $selectedSchoolYear }}</flux:button>
            <flux:menu>
                <flux:menu.radio.group wire:model.live="selectedSchoolYear">
                    @foreach ($schoolYears as $year)
                        {{-- <div wire:key="{{ $year->id }}"> --}}
                            <flux:menu.radio value="{{ $year }}">{{ $year }}</flux:menu.radio>
                            {{--
                        </div> --}}
                    @endforeach
                </flux:menu.radio.group>
            </flux:menu>
        </flux:dropdown>
    </div>

</div>