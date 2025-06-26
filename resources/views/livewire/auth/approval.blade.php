<div class="flex flex-col gap-6">
    <div class="flex w-full flex-col text-center">
        <flux:heading size="xl">Your account is awaiting Approval</flux:heading>
        <flux:subheading>LOOOOOL</flux:subheading>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="flex items-center justify-end">
      @csrf
      <flux:button variant="primary" type="submit" class="w-full">{{ __('Return') }}</flux:button>
    </form>
</div>