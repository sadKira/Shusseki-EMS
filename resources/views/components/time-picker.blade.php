<!-- Time Picker -->

{{-- <input type="text"
    class="py-2.5 sm:py-3 ps-4 pe-12 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:placeholder-neutral-400 dark:focus:ring-neutral-600"
    placeholder="hh:mm aa"> --}}
<div class="mt-7">
    <!-- Dropdown -->
    <div class="hs-dropdown [--auto-close:inside] relative inline-flex">
        <button id="hs-custom-style-time-picker" type="button"
            class="hs-dropdown-toggle size-8 shrink-0 inline-flex justify-center items-center rounded-full  text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
            aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
            {{-- <span class="sr-only">Dropdown</span> --}}
            <flux:icon.clock class="size-6 text-[var(--color-zinc-400)]" />
        </button>

        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-30 bg-white border border-gray-200 shadow-xl rounded-lg mt-2 dark:bg-neutral-800 dark:border-neutral-700 dark:divide-neutral-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full"
            role="menu" aria-orientation="vertical" aria-labelledby="hs-custom-style-time-picker">
            <div class="flex flex-row divide-x divide-gray-200 dark:divide-neutral-700">
                <!-- Hours -->
                <div
                    class="p-1 max-h-56 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-800 dark:hover:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh00"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh00"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            00
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh01"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh01"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            01
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh02"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh02"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            02
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh03"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh03"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            03
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh04"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh04"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            04
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh05"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh05"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            05
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh06"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh06"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            06
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh07"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh07"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            07
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh08"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh08"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            08
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh09"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh09"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            09
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh10"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh10"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            10
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh11"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh11"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            11
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh12"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh12"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            12
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh13"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh13"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            13
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh14"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh14"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            14
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh15"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh15"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            15
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh16"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh16"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            16
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh17"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh17"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            17
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh18"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh18"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            18
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh19"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh19"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            19
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh20"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh20"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            20
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh21"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh21"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            21
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh22"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh22"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            22
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlhh23"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlhh23"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_hour">
                        <span class="block">
                            23
                        </span>
                    </label>
                    <!-- End Checkbox -->
                </div>
                <!-- End Hours -->

                <!-- Minutes -->
                <div
                    class="p-1 max-h-56 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-800 dark:hover:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm00"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm00"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            00
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm01"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm01"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            01
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm02"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm02"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            02
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm03"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm03"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            03
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm04"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm04"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            04
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm05"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm05"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            05
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm06"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm06"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            06
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm07"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm07"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            07
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm08"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm08"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            08
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm09"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm09"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            09
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm10"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm10"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            10
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm11"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm11"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            11
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm12"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm12"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            12
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm13"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm13"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            13
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm14"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm14"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            14
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm15"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm15"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            15
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm16"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm16"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            16
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm17"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm17"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            17
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm18"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm18"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            18
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm19"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm19"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            19
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm20"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm20"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            20
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm21"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm21"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            21
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm22"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm22"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            22
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlmm23"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlmm23"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_minute">
                        <span class="block">
                            23
                        </span>
                    </label>
                    <!-- End Checkbox -->
                </div>
                <!-- End Minutes -->

                <!-- 12-Hour Clock System -->
                <div
                    class="p-1 max-h-56 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-800 dark:hover:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                    <!-- Checkbox -->
                    <label for="hs-cbchlcsam"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlcsam"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_ampm">
                        <span class="block">
                            AM
                        </span>
                    </label>
                    <!-- End Checkbox -->
                    <!-- Checkbox -->
                    <label for="hs-cbchlcspm"
                        class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
            has-checked:text-white dark:has-checked:text-white
            has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
            has-disabled:pointer-events-none
            has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
            has-disabled:after:absolute
            has-disabled:after:inset-0
            has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
            dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                        <input type="radio" id="hs-cbchlcspm"
                            class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900"
                            name="tp_ampm">
                        <span class="block">
                            PM
                        </span>
                    </label>
                    <!-- End Checkbox -->
                </div>
                <!-- End 12-Hour Clock System -->
            </div>

            <!-- Footer -->
            <!-- Removed Now and OK buttons -->
            <!-- End Footer -->
        </div>
    </div>
    <!-- End Dropdown -->
</div>


<!-- End Time Picker -->

<script>
    window.attachTimePickerListeners = function () {
        const hourRadios = document.querySelectorAll('input[name="tp_hour"]');
        const minuteRadios = document.querySelectorAll('input[name="tp_minute"]');
        const ampmRadios = document.querySelectorAll('input[name="tp_ampm"]');
        const input = document.getElementById('tp_input');

        function updateTime() {
            const hour = document.querySelector('input[name="tp_hour"]:checked')?.nextElementSibling.textContent.trim();
            const minute = document.querySelector('input[name="tp_minute"]:checked')?.nextElementSibling.textContent.trim();
            const ampm = document.querySelector('input[name="tp_ampm"]:checked')?.nextElementSibling.textContent.trim();
            if (hour && minute && ampm) {
                input.value = `${hour}:${minute} ${ampm}`;
                input.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }

        hourRadios.forEach(r => r.removeEventListener('change', updateTime));
        minuteRadios.forEach(r => r.removeEventListener('change', updateTime));
        ampmRadios.forEach(r => r.removeEventListener('change', updateTime));
        hourRadios.forEach(r => r.addEventListener('change', updateTime));
        minuteRadios.forEach(r => r.addEventListener('change', updateTime));
        ampmRadios.forEach(r => r.addEventListener('change', updateTime));
    };

    document.addEventListener('DOMContentLoaded', window.attachTimePickerListeners);
    document.addEventListener('livewire:load', window.attachTimePickerListeners);
    document.addEventListener('livewire:update', window.attachTimePickerListeners);
</script>

<style>
    /* Custom Time Picker Styling inspired by pikaday-custom.css */
    .hs-dropdown-menu {
        background: var(--main-bg-color, #292827);
        border: 1px solid var(--color-zinc-700, #3f3f46);
        border-radius: 0.5rem;
        box-shadow: 0 4px 8px -2px rgba(0, 0, 0, 0.10), 0 2px 4px -2px rgba(0, 0, 0, 0.06);
        color: var(--color-zinc-50, #fafafa);
    }

    .hs-dropdown-menu label {
        border-radius: 0.25rem;
        transition: background 0.15s, color 0.15s;
        font-size: 1rem;
        color: var(--color-zinc-50, #fafafa);
    }

    .hs-dropdown-menu label:hover,
    .hs-dropdown-menu label:focus-within {
        background: var(--color-accent, #fbbf24);
        color: var(--accent-top-text-color, #fff);
    }

    .hs-dropdown-menu input[type="radio"]:checked+span {
        background: var(--color-accent, #fbbf24) !important;
        color: var(--accent-top-text-color, #fff) !important;
        border-radius: 0.25rem;
        font-weight: bold;
        box-shadow: none;
    }

    .hs-dropdown-menu .flex>div {
        scrollbar-width: thin;
        scrollbar-color: var(--color-accent, #fbbf24) var(--main-bg-color, #292827);
    }

    .hs-dropdown-menu .flex>div::-webkit-scrollbar {
        width: 8px;
        background: var(--main-bg-color, #292827);
    }

    .hs-dropdown-menu .flex>div::-webkit-scrollbar-thumb {
        background: var(--color-accent, #fbbf24);
        border-radius: 8px;
    }

    /* Remove any blue-specific classes for checked state */
    .hs-dropdown-menu label.has-checked {
        background: var(--color-accent, #fbbf24) !important;
        color: var(--accent-top-text-color, #fff) !important;
    }
</style>