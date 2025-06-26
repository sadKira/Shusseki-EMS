{{-- <div class="bg-white dark:bg-zinc-800"> --}}
<div>
    <div class="sticky top-0 z-10 bg-white dark:bg-zinc-800">

        {{-- App Header --}}
        <div class=" relative mb-6 w-full">

            <div class="flex items-center">
                <flux:navbar class="-mb-px max-lg:hidden">
                    <flux:navbar.item icon="user-group" :href="route('manage_students')"
                    wire:navigate>Student List
                    </flux:navbar.item>
                    <flux:separator vertical variant="subtle" class="my-2" />
                    <flux:navbar.item icon="shield-check" :href="route('manage_approval')"
                    wire:navigate>Student Approval
                    </flux:navbar.item>
                </flux:navbar>
                {{-- <flux:navbar class="me-4">
                    <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle"
                        aria-label="Toggle dark mode" />
                    <flux:navbar.item class="max-lg:hidden" icon="cog-6-tooth" href="#" label="Settings" />
                </flux:navbar> --}}
            </div>

            {{-- Mobile View --}}
            <div class="lg:hidden">
                <flux:navbar class="-mb-px w-full">
                    <flux:navbar.item icon="user-group" :href="route('manage_students')"
                    wire:navigate>Student List
                    </flux:navbar.item>

                    <flux:navbar.item icon="shield-check" :href="route('manage_approval')"
                    wire:navigate>Student Approval
                    </flux:navbar.item>
                    <flux:spacer />
                </flux:navbar>
            </div>

            <flux:separator variant="subtle" class="" />

        </div>
    </div> 

    {{-- Breadcrumbs --}}
    <div class="flex justify-end max-lg:hidden">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('manage_students')" wire:navigate>Students
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('manage_students')" :accent="true" wire:navigate>
                <span  class="text-[var(--color-accent)]">Student List<span>
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    {{-- Main text --}}
    <div class="flex items-end space-x-5">
        <flux:heading size="xl">Student Count: </flux:heading>
        {{-- <flux:heading size="l">Count: </flux:heading> --}}
    </div>

    @script
        <script>
            setInterval(() => {
                $wire.$refresh()
            }, 5000)
        </script>
    @endscript

    {{-- Table --}}
    <livewire:management.filter-table />

</div> 