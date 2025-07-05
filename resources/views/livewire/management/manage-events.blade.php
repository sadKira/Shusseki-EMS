<div class="h-full rounded-lg p-10 dark:bg-zinc-800">
    {{-- App Header --}}
    <div class=" relative mb-6 w-full">
        <flux:heading size="xl" level="1">Manage Events</flux:heading>
        {{-- Breadcrumbs --}}
        <div class="mt-2 flex">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_events')" wire:navigate>Events
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_events')" :accent="true" wire:navigate>
                    <span class="text-[var(--color-accent)]">Manage Events<span>
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
    </div>

    <div class="flex items-center justify-between">
        {{-- Month--}}
        <div class="mt-10">
            <flux:heading size="xl" level="1">Monday, July 12</flux:heading>
            <flux:heading size="lg" level="1">A.Y. 2024-25</flux:heading>


        </div>
        {{-- Upcoming events --}}
        <div>
            <flux:heading size="xl" level="1">No Upcoming Events</flux:heading>
        </div>
    </div>

    {{-- Events --}}

    <div class="flex min-h-screen dark:border-neutral-700">

        {{-- Left side --}}
        <div class="p-6" style="flex: 60 1 0px;">
            <div class="flex flex-col items-center h-full text-gray-800 dark:text-neutral-200">

                {{-- Events this month --}}
                <section class="w-full flex items-center justify-start mt-10 gap-2">
                    <flux:heading size="lg" level="1">Events for the month of: JUNE</flux:heading>
                    <flux:dropdown>
                        <flux:button variant="filled" icon="chevron-down" size="sm"></flux:button>
                        <flux:menu>
                            <flux:menu.radio.group>
                                <flux:menu.radio checked>January</flux:menu.radio>
                                <flux:menu.radio>February</flux:menu.radio>
                                <flux:menu.radio>March</flux:menu.radio>
                                <flux:menu.radio>April</flux:menu.radio>
                                <flux:menu.radio>May</flux:menu.radio>
                                <flux:menu.radio>June</flux:menu.radio>
                                <flux:menu.radio>July</flux:menu.radio>
                                <flux:menu.radio>August</flux:menu.radio>
                                <flux:menu.radio>September</flux:menu.radio>
                                <flux:menu.radio>October</flux:menu.radio>
                                <flux:menu.radio>November</flux:menu.radio>
                                <flux:menu.radio>December</flux:menu.radio>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>
                </section>

                <!-- Slider -->
                <div data-hs-carousel='{
                    "loadingClasses": "opacity-0",
                    "dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer dark:border-neutral-600 dark:hs-carousel-active:bg-blue-500 dark:hs-carousel-active:border-blue-500",
                    "slidesQty": {
                        "xs": 1,
                        "lg": 2
                    }
                        
                    }' class="relative mt-5">
                    <div class="hs-carousel w-[600px] overflow-hidden bg-white rounded-lg dark:bg-zinc-800">
                        <div class="relative min-h-90 -mx-1">
                            <!-- transition-transform duration-700 -->
                            <div
                                class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap opacity-0 transition-transform duration-700">
                                <div class="hs-carousel-slide px-3">
                                    <div
                                        class="flex flex-col bg-white shadow-2xs rounded-lg hover:shadow-lg hover:shadow-amber-400/20 focus:outline-hidden focus:shadow-lg focus:shadow-amber-400/20 transition dark:bg-zinc-950 dark:border-zinc-700 dark:shadow-zinc-700/70 dark:hover:shadow-amber-400/20 dark:focus:shadow-amber-400/20">
                                        <img class="w-full h-auto rounded-t-xl"
                                            src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80"
                                            alt="Card Image">
                                        <div class="p-4 md:p-5">
                                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                                Card title
                                            </h3>
                                            <p class="mt-1 text-gray-500 dark:text-neutral-400">
                                                Some quick example text to build on the card title and make up the
                                                bulk of the card's content.
                                            </p>
                                            <p class="mt-5 text-xs text-gray-500 dark:text-neutral-500">
                                                Last updated 5 mins ago
                                            </p>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>

                    <button type="button"
                        class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 rounded-s-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                        <span class="text-2xl" aria-hidden="true">
                            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m15 18-6-6 6-6"></path>
                            </svg>
                        </span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button type="button"
                        class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 rounded-e-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                        <span class="sr-only">Next</span>
                        <span class="text-2xl" aria-hidden="true">
                            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </span>
                    </button>

                    {{-- Pagination --}}
                    <div
                        class="hs-carousel-info inline-flex justify-center px-4 py-2 absolute bottom-3 start-[50%] -translate-x-[50%] bg-white border border-zinc-200 shadow-sm rounded-lg text-sm font-medium text-zinc-700 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-300">
                        <span class="hs-carousel-info-current me-1 text-amber-600 dark:text-amber-400">0</span>
                        /
                        <span class="hs-carousel-info-total ms-1">0</span>
                    </div>


                </div>
                <!-- End Slider -->

                {{-- Events next month --}}
                <section class="w-full flex items-center justify-start mt-10 gap-2">
                    <flux:heading size="lg" level="1">Upcoming Events: AUGUST</flux:heading>
                    <flux:dropdown>
                        <flux:button variant="filled" icon="chevron-down" size="sm" class="gap-2"></flux:button>
                        <flux:menu>
                            <flux:menu.radio.group>
                                <flux:menu.radio checked>January</flux:menu.radio>
                                <flux:menu.radio>February</flux:menu.radio>
                                <flux:menu.radio>March</flux:menu.radio>
                                <flux:menu.radio>April</flux:menu.radio>
                                <flux:menu.radio>May</flux:menu.radio>
                                <flux:menu.radio>June</flux:menu.radio>
                                <flux:menu.radio>July</flux:menu.radio>
                                <flux:menu.radio>August</flux:menu.radio>
                                <flux:menu.radio>September</flux:menu.radio>
                                <flux:menu.radio>October</flux:menu.radio>
                                <flux:menu.radio>November</flux:menu.radio>
                                <flux:menu.radio>December</flux:menu.radio>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>
                </section>

                {{-- Wide Card --}}
                <div class="bg-white rounded-lg shadow-2xs sm:flex h-48 overflow-hidden
                            hover:shadow-lg hover:shadow-amber-400/20 focus:outline-none focus:shadow-lg focus:shadow-amber-400/20 
                            transition dark:bg-zinc-950 dark:border-zinc-700 dark:shadow-zinc-700/70 
                            dark:hover:shadow-amber-400/20 dark:focus:shadow-amber-400/20 mt-5">

                    <!-- Image section with fixed height -->
                    <div class="shrink-0 relative w-full sm:w-60 md:w-72 h-full">
                    <img
                        class="w-full h-full object-cover rounded-l-xl"
                        src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=560&q=80"
                        alt="Card Image">
                    </div>


                    <!-- Text content -->
                    <div class="flex flex-col justify-between p-4 sm:p-7 flex-1 h-full">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                Card title
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                                Some quick example text to build on the card title and make up the bulk of the
                                card's content.
                            </p>
                        </div>
                        <div class="mt-4">
                            <p class="text-xs text-gray-500 dark:text-neutral-500">
                                Last updated 5 mins ago
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <flux:separator vertical variant="subtle" />

        {{-- Right side --}}
        <div class="p-6 flex items-start"  style="flex: 30 1 0px;">
            <div class="flex items-center justify-center h-full p-3 text-gray-800 dark:text-neutral-200">
                <!-- Timeline -->
                <div>
                    <!-- Heading -->
                    <div class="   ps-2 my-2 first:mt-0">
                        <h3 class="text-xs font-medium uppercase text-gray-500 dark:text-neutral-400">
                            1 Aug, 2023
                        </h3>
                    </div>
                    <!-- End Heading -->

                    <!-- Item -->
                    <div class="flex gap-x-3">
                        <!-- Icon -->
                        <div
                            class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
                            <div class="relative z-10 size-7 flex justify-center items-center">
                                <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
                            </div>
                        </div>
                        <!-- End Icon -->

                        <!-- Right Content -->
                        <div class="grow pt-0.5 pb-8">
                            <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
                                <svg class="shrink-0 size-4 mt-1" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z">
                                    </path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" x2="8" y1="13" y2="13"></line>
                                    <line x1="16" x2="8" y1="17" y2="17"></line>
                                    <line x1="10" x2="8" y1="9" y2="9"></line>
                                </svg>
                                Created "Preline in React" task
                            </h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
                                Find more detailed insctructions here.
                            </p>
                            <button type="button"
                                class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                <img class="shrink-0 size-4 rounded-full"
                                    src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8auto=format&fit=facearea&facepad=3&w=320&h=320&q=80"
                                    alt="Avatar">
                                James Collins
                            </button>
                        </div>
                        <!-- End Right Content -->
                    </div>
                    <!-- End Item -->

                    <!-- Item -->
                    <div class="flex gap-x-3">
                        <!-- Icon -->
                        <div
                            class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
                            <div class="relative z-10 size-7 flex justify-center items-center">
                                <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
                            </div>
                        </div>
                        <!-- End Icon -->

                        <!-- Right Content -->
                        <div class="grow pt-0.5 pb-8">
                            <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
                                Release v5.2.0 quick bug fix 🐞
                            </h3>
                            <button type="button"
                                class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                <span
                                    class="flex shrink-0 justify-center items-center size-4 bg-white border border-gray-200 text-[10px] font-semibold uppercase text-gray-600 rounded-full dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
                                    A
                                </span>
                                Alex Gregarov
                            </button>
                        </div>
                        <!-- End Right Content -->
                    </div>
                    <!-- End Item -->

                    <!-- Item -->
                    <div class="flex gap-x-3">
                        <!-- Icon -->
                        <div
                            class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
                            <div class="relative z-10 size-7 flex justify-center items-center">
                                <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
                            </div>
                        </div>
                        <!-- End Icon -->

                        <!-- Right Content -->
                        <div class="grow pt-0.5 pb-8">
                            <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
                                Marked "Install Charts" completed
                            </h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
                                Finally! You can check it out here.
                            </p>
                            <button type="button"
                                class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                <img class="shrink-0 size-4 rounded-full"
                                    src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80"
                                    alt="Avatar">
                                James Collins
                            </button>
                        </div>
                        <!-- End Right Content -->
                    </div>
                    <!-- End Item -->

                    <!-- Heading -->
                    <div class="ps-2 my-2 first:mt-0">
                        <h3 class="text-xs font-medium uppercase text-gray-500 dark:text-neutral-400">
                            31 Jul, 2023
                        </h3>
                    </div>
                    <!-- End Heading -->

                    <!-- Item -->
                    <div class="flex gap-x-3">
                        <!-- Icon -->
                        <div
                            class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
                            <div class="relative z-10 size-7 flex justify-center items-center">
                                <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
                            </div>
                        </div>
                        <!-- End Icon -->

                        <!-- Right Content -->
                        <div class="grow pt-0.5 pb-8">
                            <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
                                Take a break ⛳️
                            </h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
                                Just chill for now... 😉
                            </p>
                        </div>
                        <!-- End Right Content -->
                    </div>
                    <!-- End Item -->
                </div>
                <!-- End Timeline -->
            </div>
        </div>

    </div>

    @script
    <script>window.HSStaticMethods.autoInit();</script>
    @endscript

</div>