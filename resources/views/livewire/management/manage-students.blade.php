{{-- <div class="bg-white dark:bg-zinc-800"> --}}
<div>
    <div class="sticky top-0 z-10 bg-white dark:bg-zinc-800">
        {{-- App Header --}}
        <div class=" relative mb-6 w-full">
            <div class="flex items-center">
                {{-- <flux:heading size="xl" level="1">Students</flux:heading>
                <flux:spacer /> --}}

                <flux:navbar class="-mb-px max-lg:hidden">
                    <flux:navbar.item icon="user-group" :href="route('manage_students')"
                        :current="request()->routeIs(['manage_students'])" wire:navigate>Student List
                    </flux:navbar.item>
                    <flux:separator vertical variant="subtle" class="my-2" />
                    <flux:navbar.item icon="shield-check" :href="route('manage_approval')"
                        :current="request()->routeIs(['manage_approval'])" wire:navigate>Student Approval
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

        <div class="flex justify-end max-lg:hidden">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_students')" wire:navigate>Students
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_students')" :accent="true" wire:navigate>Student List
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
    </div> 

    <div class="flex items-end space-x-5">
        <flux:heading size="xl">Total Students Count: </flux:heading>
        {{-- <flux:heading size="l">Count: </flux:heading> --}}
    </div>

    {{-- Buttons --}}
    <div class="mt-5 flex items-center justify-between max-lg:hidden">
        <div class="flex items-center space-x-1">
            <flux:dropdown>
                <flux:button variant="filled" icon:trailing="chevron-down">Semester</flux:button>
                <flux:menu>
                    <flux:menu.radio.group wire:model="sortBy">
                        <flux:menu.radio checked>1st Semester</flux:menu.radio>
                        <flux:menu.radio>2nd Semester</flux:menu.radio>
                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>
            <flux:dropdown>
                <flux:button variant="ghost" icon:trailing="chevron-down">Year Level</flux:button>
                <flux:menu>
                        <flux:menu.radio checked>1st Year</flux:menu.radio>
                        <flux:menu.radio>2nd Year</flux:menu.radio>
                        <flux:menu.radio>3rd Year</flux:menu.radio>
                        <flux:menu.radio>4th Year</flux:menu.radio>
                </flux:menu>
            </flux:dropdown>
            <flux:dropdown>
                <flux:button variant="ghost" icon:trailing="chevron-down">Course</flux:button>
                <flux:menu>
                        <flux:menu.radio checked>Bachelor of Arts in International Studies</flux:menu.radio>
                        <flux:menu.radio>Bachelor of Science in Information Systems</flux:menu.radio>
                        <flux:menu.radio>Bachelor of Human Services</flux:menu.radio>
                        <flux:menu.radio>Bachelor of Secondary Education</flux:menu.radio>
                </flux:menu>
            </flux:dropdown>
        </div>
        <div> 
            <flux:input icon="magnifying-glass" placeholder="Search..." />
        </div>
    </div>

    {{-- Mobile View Buttons --}}
    <div class="mt-5 relative justify-between lg:hidden">
        <div class="flex items-center space-x-1">
            <flux:dropdown>
                <flux:button variant="filled" icon:trailing="chevron-down">Semester</flux:button>
                <flux:menu>
                    <flux:menu.radio.group wire:model="sortBy">
                        <flux:menu.radio checked>1st Semester</flux:menu.radio>
                        <flux:menu.radio>2nd Semester</flux:menu.radio>
                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>
            <flux:dropdown>
                <flux:button variant="ghost" icon:trailing="chevron-down">Year Level</flux:button>
                <flux:menu>
                        <flux:menu.radio checked>1st Year</flux:menu.radio>
                        <flux:menu.radio>2nd Year</flux:menu.radio>
                        <flux:menu.radio>3rd Year</flux:menu.radio>
                        <flux:menu.radio>4th Year</flux:menu.radio>
                </flux:menu>
            </flux:dropdown>
            <flux:dropdown>
                <flux:button variant="ghost" icon:trailing="chevron-down">Course</flux:button>
                <flux:menu>
                        <flux:menu.radio checked>Bachelor of Arts in International Studies</flux:menu.radio>
                        <flux:menu.radio>Bachelor of Science in Information Systems</flux:menu.radio>
                        <flux:menu.radio>Bachelor of Human Services</flux:menu.radio>
                        <flux:menu.radio>Bachelor of Secondary Education</flux:menu.radio>
                </flux:menu>
            </flux:dropdown>
        </div>
        <div class="mt-5"> 
            <flux:input icon="magnifying-glass" placeholder="Search..." />
        </div>
    </div>


    {{-- Table --}}
    <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-zinc-600 dark:text-zinc-400">
            <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-amber-600 bg-zinc-100 border-zinc-300 rounded-sm focus:ring-amber-500 dark:focus:ring-amber-400 dark:ring-offset-zinc-900 dark:focus:ring-offset-zinc-900 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600">
                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Student Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Year Level
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Course
                    </th>
                    <th scope="col" class="px- py-3 pl-16.5">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700 border-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-amber-600 bg-zinc-100 border-zinc-300 rounded-sm focus:ring-amber-500 dark:focus:ring-amber-400 dark:ring-offset-zinc-900 dark:focus:ring-offset-zinc-900 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-zinc-100">
                        Slim Shady
                    </th>
                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                        deminem@gmail.com
                    </td>
                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                        1st Year
                    </td>
                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                        BS In Information Systems
                    </td>
                    <td class="flex items-center px-6 py-4">
                        <flux:button variant="primary" color="AMber">Mark as Inactive</flux:button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div> 