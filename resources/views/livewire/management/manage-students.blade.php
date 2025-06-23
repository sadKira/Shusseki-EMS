<div class="bg-white dark:bg-zinc-800">
    <flux:main container>
        <div class="sticky top-0 z-10 bg-white dark:bg-zinc-800">
            {{-- App Header --}}
            <div class=" relative mb-6 w-full">
                <div class="flex items-center">
                    <flux:heading size="xl" level="1">Students</flux:heading>

                    <flux:spacer />

                    <flux:navbar class="-mb-px max-lg:hidden">
                        <flux:navbar.item icon="user-group" :href="route('manage_students')"
                            :current="request()->routeIs(['manage_students'])" wire:navigate>Student List
                        </flux:navbar.item>
                        <flux:separator vertical variant="subtle" class="my-2" />
                        <flux:navbar.item icon="shield-check" :href="route('manage_approval')"
                            :current="request()->routeIs(['manage_approval'])" wire:navigate>Student Approval
                        </flux:navbar.item>
                    </flux:navbar>
                    <flux:navbar class="me-4">
                        <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle"
                            aria-label="Toggle dark mode" />
                        <flux:navbar.item class="max-lg:hidden" icon="cog-6-tooth" href="#" label="Settings" />
                    </flux:navbar>
                </div>
                {{-- Mobile View --}}
                <div class="lg:hidden">
                    <flux:navbar class="-mb-px w-full">

                        <flux:navbar.item icon="user-group" :href="route('manage_students')"
                            :current="request()->routeIs(['manage_students'])" wire:navigate>Student List
                        </flux:navbar.item>

                    <flux:navbar.item icon="shield-check" :href="route('manage_approval')"
                        :current="request()->routeIs(['manage_approval'])" wire:navigate>Student Approval
                    </flux:navbar.item>
                    <flux:spacer />
            </flux:navbar>
        </div>
        <flux:separator variant="subtle" class="" />
    </div>
    
    <div class="flex justify-end">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('manage_students')" wire:navigate>Students</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('manage_students')" :accent="true" wire:navigate>Student List
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>


    <div class="flex items-end space-x-5">
        <flux:heading size="xl">Total Students</flux:heading>
        <flux:heading size="l">Count: </flux:heading>
    </div>


    <div class=" mt-5 flex items-center justify-between">
        <div class="flex items-center space-x-1">
            <flux:dropdown>
                <flux:button variant="filled" icon:trailing="chevron-down">1st Semester</flux:button>
                <flux:menu>
                    <flux:menu.radio.group wire:model="sortBy">
                        <flux:menu.radio checked>1st Semester</flux:menu.radio>
                        <flux:menu.radio>2nd Semester</flux:menu.radio>
                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>
            <flux:dropdown>
                <flux:button variant="ghost" icon:trailing="chevron-down">Options</flux:button>
                <flux:menu>
                    <flux:menu.submenu heading="Sort by">
                        <flux:menu.radio checked>Year Level</flux:menu.radio>
                        <flux:menu.radio>Course</flux:menu.radio>
                    </flux:menu.submenu>
                    <flux:menu.separator />
                    <flux:menu.item variant="danger">Reset Accounts</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </div>
        <div>
            <flux:input icon="magnifying-glass" placeholder="Search..." />
        </div>
    </div>









    </flux:main>


</div>