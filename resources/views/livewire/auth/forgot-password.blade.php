 <div class="flex flex-col gap-6">

    {{-- Form header --}}
    <div class="flex w-full flex-col text-center">
        <flux:heading size="xl">Forgot password</flux:heading>
        <flux:subheading>Enter your email to receive a password reset link</flux:subheading>
    </div>
    
    <!-- Session Status -->
    {{-- <x-auth-session-status class="text-center" :status="session('status')" /> --}}
    <div x-data="{ shown: false }" x-init="
            @this.on('forgot-password', () => {
                shown = true;
                {{-- setTimeout(() => { shown = false }, 3000); --}}
            })
        " class="">

        <!-- Callout (shown temporarily when event fires) -->
        <template x-if="shown">
            <flux:callout variant="success" icon="check-circle" heading="A reset link will be sent if the account exists" />
        </template>

    </div>

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email Address')"
            type="email"
            required
            autofocus
            placeholder="email@example.com"
            viewable
        />

        <flux:button variant="primary" type="submit" class="w-full">{{ __('Email password reset link') }}</flux:button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
        {{ __('Or, return to') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('log in') }}</flux:link>
    </div>
</div>
