<!-- Time Picker 2 (Duplicate) -->

<div class="mt-7">
    <!-- Dropdown -->
    <div class="hs-dropdown [--auto-close:inside] relative inline-flex">
        <button id="hs-custom-style-time-picker-2" type="button" class="hs-dropdown-toggle size-8 shrink-0 inline-flex justify-center items-center rounded-full  text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
            <flux:icon.clock class="size-6 text-[var(--color-zinc-400)]" />
        </button>

        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-30 bg-white border border-gray-200 shadow-xl rounded-lg mt-2 dark:bg-neutral-800 dark:border-neutral-700 dark:divide-neutral-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full" role="menu" aria-orientation="vertical" aria-labelledby="hs-custom-style-time-picker-2">
            <div class="flex flex-row divide-x divide-gray-200 dark:divide-neutral-700">
                <!-- Hours -->
                <div class="p-1 max-h-56 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-800 dark:hover:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                    <!-- Checkbox -->
                    @for ($i = 0; $i < 13; $i++)
                    <label for="hs-cbchlhh{{ sprintf('%02d', $i) }}-2" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
                    has-checked:text-white dark:has-checked:text-white
                    has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
                    has-disabled:pointer-events-none
                    has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
                    has-disabled:after:absolute
                    has-disabled:after:inset-0
                    has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
                    dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                    <input type="radio" id="hs-cbchlhh{{ sprintf('%02d', $i) }}-2" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="tp_hour_2">
                    <span class="block">
                        {{ sprintf('%02d', $i) }}
                    </span>
                    </label>
                    @endfor
                </div>
                <!-- End Hours -->

                <!-- Minutes -->
                <div class="p-1 max-h-56 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-800 dark:hover:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                    @for ($i = 0; $i < 60; $i++)
                    <label for="hs-cbchlmm{{ sprintf('%02d', $i) }}-2" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
                    has-checked:text-white dark:has-checked:text-white
                    has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
                    has-disabled:pointer-events-none
                    has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
                    has-disabled:after:absolute
                    has-disabled:after:inset-0
                    has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
                    dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                    <input type="radio" id="hs-cbchlmm{{ sprintf('%02d', $i) }}-2" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="tp_minute_2">
                    <span class="block">
                        {{ sprintf('%02d', $i) }}
                    </span>
                    </label>
                    @endfor
                </div>
                <!-- End Minutes -->

                <!-- 12-Hour Clock System -->
                <div class="p-1 max-h-56 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-800 dark:hover:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                    <label for="hs-cbchlcsam-2" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
                    has-checked:text-white dark:has-checked:text-white
                    has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
                    has-disabled:pointer-events-none
                    has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
                    has-disabled:after:absolute
                    has-disabled:after:inset-0
                    has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
                    dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                    <input type="radio" id="hs-cbchlcsam-2" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="tp_ampm_2">
                    <span class="block">
                        AM
                    </span>
                    </label>
                    <label for="hs-cbchlcspm-2" class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200
                    has-checked:text-white dark:has-checked:text-white
                    has-checked:bg-[var(--color-accent)] dark:has-checked:bg-[var(--color-accent)]
                    has-disabled:pointer-events-none
                    has-disabled:text-gray-200 dark:has-disabled:text-neutral-700
                    has-disabled:after:absolute
                    has-disabled:after:inset-0
                    has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-gray-200)_calc(50%-1px),var(--color-gray-200)_50%,transparent_50%)]
                    dark:has-disabled:after:bg-[linear-gradient(to_right_bottom,transparent_calc(50%-1px),var(--color-neutral-700)_calc(50%-1px),var(--color-neutral-700)_50%,transparent_50%)] ">
                    <input type="radio" id="hs-cbchlcspm-2" class="hidden bg-transparent border-gray-200 text-blue-600 focus:ring-white focus:ring-offset-0 dark:text-blue-500 dark:border-neutral-700 dark:focus:ring-neutral-900" name="tp_ampm_2">
                    <span class="block">
                        PM
                    </span>
                    </label>
                </div>
                <!-- End 12-Hour Clock System -->
            </div>
        </div>
    </div>
    <!-- End Dropdown -->
</div>

<script>
window.attachTimePickerListeners2 = function() {
  const hourRadios = document.querySelectorAll('input[name="tp_hour_2"]');
  const minuteRadios = document.querySelectorAll('input[name="tp_minute_2"]');
  const ampmRadios = document.querySelectorAll('input[name="tp_ampm_2"]');
  const input = document.getElementById('tp_input_2');

  function updateTime() {
    const hour = document.querySelector('input[name="tp_hour_2"]:checked')?.nextElementSibling.textContent.trim();
    const minute = document.querySelector('input[name="tp_minute_2"]:checked')?.nextElementSibling.textContent.trim();
    const ampm = document.querySelector('input[name="tp_ampm_2"]:checked')?.nextElementSibling.textContent.trim();
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

document.addEventListener('DOMContentLoaded', window.attachTimePickerListeners2);
document.addEventListener('livewire:load', window.attachTimePickerListeners2);
document.addEventListener('livewire:update', window.attachTimePickerListeners2);
</script>

<style>
/* Custom Time Picker Styling inspired by pikaday-custom.css */
.hs-dropdown-menu {
  background: var(--main-bg-color, #292827);
  border: 1px solid var(--color-zinc-700, #3f3f46);
  border-radius: 0.5rem;
  box-shadow: 0 4px 8px -2px rgba(0,0,0,0.10), 0 2px 4px -2px rgba(0,0,0,0.06);
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
.hs-dropdown-menu input[type="radio"]:checked + span {
  background: var(--color-accent, #fbbf24) !important;
  color: var(--accent-top-text-color, #fff) !important;
  border-radius: 0.25rem;
  font-weight: bold;
  box-shadow: none;
}

/* Remove any blue-specific classes for checked state */
.hs-dropdown-menu label.has-checked {
  background: var(--color-accent, #fbbf24) !important;
  color: var(--accent-top-text-color, #fff) !important;
}
.hs-dropdown-menu .flex > div {
  scrollbar-width: thin;
  scrollbar-color: var(--color-accent, #fbbf24) var(--main-bg-color, #292827);
}
.hs-dropdown-menu .flex > div::-webkit-scrollbar {
  width: 8px;
  background: var(--main-bg-color, #292827);
}
.hs-dropdown-menu .flex > div::-webkit-scrollbar-thumb {
  background: var(--color-accent, #fbbf24);
  border-radius: 8px;
}
</style> 