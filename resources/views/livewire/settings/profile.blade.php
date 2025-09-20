<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('View account details')">

        <div class="grid grid-cols-2 items-center gap-4">

            {{-- Locked name --}}
            <flux:input type="text" wire:model="name" icon:trailing="lock-closed" readonly :label="__('Name')" />

            {{-- Locked email --}}
            <flux:input wire:model="email" :label="__('Email')" type="email" readonly copyable />

            {{-- Admin accounts --}}

            @if(auth()->check() && auth()->user()->student_id === '0000001')
                
           
                {{-- Super Admin --}}
                <div class="mt-10">

                    <flux:heading>Administrator Privileges</flux:heading>
                
                    <div
                        class="flex mt-4 gap-2 text-sm font-medium text-gray-800 dark:text-neutral-200">

                        <flux:profile circle class="" 
                        initials="SA"
                        :chevron="false"
                        />

                        <div class="flex flex-col">
                            
                            <div class="flex items-center gap-1 ">

                                <div class="font-bold">Super Admin</div>

                                <flux:icon.check variant="mini" class="text-green-500" />

                            </div>

                            <div class="text-zinc-400">superadmin@shusseki.com</div>

                        </div>
                    </div>
                </div>

                <div class="mt-10">

                    <flux:heading class="mb-4 opacity-0">Allow SA Privilege</flux:heading>
                        
                    <flux:radio.group size="sm" variant="segmented" disabled >
                        <flux:radio label="SAP Enabled"  />
                    </flux:radio.group>
                    
                </div>
            
        
                {{-- Admin 1 --}}
                <div class="">
                
                    <div
                        class="flex gap-2 text-sm font-medium text-gray-800 dark:text-neutral-200">

                        <flux:profile circle class="" 
                        initials="AD1"
                        :chevron="false"
                        />

                        <div class="flex flex-col">
                            
                            <div class="flex items-center gap-1 ">

                                <div class="font-bold">Admin 1</div>

                                @if($user->privilege === \App\Enums\UserPrivilege::Yes)
                                    <flux:icon.check variant="mini" class="text-green-500" />
                                @else
                                    <flux:icon.x-mark variant="mini" class="text-red-500" />
                                @endif
                                
                            </div>
                            <div class="text-zinc-400">admin1@shusseki.com</div>
                        </div>
                    </div>
                </div>

                <div class="">
                
                    @can('SA')

                        <flux:radio.group wire:model.live="privilege" size="sm" variant="segmented" >
                            <flux:radio value="yes" label="SAP Enabled"  />
                            <flux:radio value="no" label="SAP Disabled" />
                        </flux:radio.group>

                    @endcan

                    @can('A')
                        
                        <flux:radio.group wire:model.live="privilege" size="sm" variant="segmented" disabled >
                            <flux:radio value="yes" label="SAP Enabled"  />
                            <flux:radio value="no" label="SAP Disabled" />
                        </flux:radio.group>

                    @endcan
                    
                </div>

                {{-- Admin 2 --}}
                <div class="">
                
                    <div
                        class="flex gap-2 text-sm font-medium text-gray-800 dark:text-neutral-200">

                        <flux:profile circle class="" 
                        initials="AD2"
                        :chevron="false"
                        />

                        <div class="flex flex-col">
                            
                            <div class="flex items-center gap-1 ">

                                <div class="font-bold">Admin 2</div>

                                <flux:icon.x-mark variant="mini" class="text-red-500" />

                            </div>

                            <div class="text-zinc-400">admin2@shusseki.com</div>
                            
                        </div>
                    </div>
                </div>

                <div class="">
                        
                    <flux:radio.group size="sm" variant="segmented" disabled >
                        <flux:radio label="SAP Disabled"  />
                    </flux:radio.group>
                    
                </div>

            @elseif (auth()->check() && auth()->user()->student_id === '0000002')

                {{-- Admin 1 --}}
                <div class="mt-10">

                    <flux:heading>Administrator Privileges</flux:heading>
                
                    <div
                        class="flex mt-4 gap-2 text-sm font-medium text-gray-800 dark:text-neutral-200">

                        <flux:profile circle class="" 
                        initials="AD1"
                        :chevron="false"
                        />

                        <div class="flex flex-col">
                            
                            <div class="flex items-center gap-1 ">

                                <div class="font-bold">Admin 1</div>

                                @if($user->privilege === \App\Enums\UserPrivilege::Yes)
                                    <flux:icon.check variant="mini" class="text-green-500" />
                                @else
                                    <flux:icon.x-mark variant="mini" class="text-red-500" />
                                @endif
                                
                            </div>
                            <div class="text-zinc-400">admin1@shusseki.com</div>
                        </div>
                    </div>
                </div>

                <div class="mt-10">

                    <flux:heading class="mb-4 opacity-0">Allow SA Privilege</flux:heading>
                
                    @if (auth()->check() && auth()->user()->privilege === \App\Enums\UserPrivilege::Yes)
                        
                        
                        <flux:radio.group wire:model.live="privilege" size="sm" variant="segmented" disabled >
                            <flux:radio label="SAP Enabled"  />
                        </flux:radio.group>

                    @else

                        <flux:radio.group wire:model.live="privilege" size="sm" variant="segmented" disabled >
                            <flux:radio label="SAP Disabled"  />
                        </flux:radio.group>

                    @endif
                    
                </div>

            @else

                {{-- Admin 2 --}}
                <div class="mt-10">
                
                    <flux:heading>Administrator Privileges</flux:heading>

                    <div
                        class="flex mt-4 gap-2 text-sm font-medium text-gray-800 dark:text-neutral-200">

                        <flux:profile circle class="" 
                        initials="AD2"
                        :chevron="false"
                        />

                        <div class="flex flex-col">
                            
                            <div class="flex items-center gap-1 ">

                                <div class="font-bold">Admin 2</div>

                                <flux:icon.x-mark variant="mini" class="text-red-500" />

                            </div>

                            <div class="text-zinc-400">admin2@shusseki.com</div>
                            
                        </div>
                    </div>
                </div>

                <div class="mt-10">

                    <flux:heading class="mb-4 opacity-0">Allow SA Privilege</flux:heading>
                        
                    <flux:radio.group size="sm" variant="segmented" disabled >
                        <flux:radio label="SAP Disabled"  />
                    </flux:radio.group>
                    
                </div>
                

            @endif
            

        </div>

        {{-- Profile update --}}
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">

            {{-- Name input field --}}
            {{-- Email input field --}}

            <div>
                {{-- Email input field --}}

                {{-- @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif --}}
            </div>

            {{-- Profile Update button --}}
            <div x-data="{ shown: false }" x-init="
                    @this.on('profile-updated', () => {
                        shown = true;
                        setTimeout(() => { shown = false }, 3000);
                    })
                " class="">

                <!-- Button (default, shown when callout is hidden) -->
                <template x-if="!shown">
                    {{-- <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button> --}}
                </template>

                <!-- Callout (shown temporarily when event fires) -->
                <template x-if="shown">
                    <flux:callout variant="success" icon="check-circle" heading="Profile Updated" />
                </template>

            </div>
        </form>

    </x-settings.layout>
</section>
