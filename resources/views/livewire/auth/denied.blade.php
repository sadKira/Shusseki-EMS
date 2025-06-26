<div class="flex flex-col gap-6">
    <div class="flex w-full flex-col text-center">
        <flux:heading size="xl" class="md:text-2xl mb-2">You Cannot Access This Account</flux:heading>
        <flux:subheading class="md:text-base mb-6">Access to your account is restricted because it is currently marked as inactive. For further assistance, please reach out to any Gakusei Jichikai (GJ) officer</flux:subheading>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="flex items-center justify-end md:w-auto">
      @csrf
      <flux:button variant="primary" type="submit" class="w-full">{{ __('Back to Home') }}</flux:button>
    </form>
</div>