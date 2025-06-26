<div class="flex flex-col gap-6">
    <div class="flex w-full flex-col text-center">
        <flux:heading size="xl" class="md:text-2xl mb-2">Hang Tight! We're Reviewing Your Account</flux:heading>
        <flux:subheading class="md:text-base mb-6">Your account is under review. You wil receive an update as soon as it's approved</flux:subheading>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="flex items-center justify-end md:w-auto">
      @csrf
      <flux:button variant="primary" type="submit" class="w-full">{{ __('Return') }}</flux:button>
    </form>
</div>