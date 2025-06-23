import './../../vendor/power-components/livewire-powergrid/dist/powergrid'


import anchor from "@alpinejs/anchor";
import collapse from "@alpinejs/collapse";
 
Alpine.plugin(anchor);
Alpine.plugin(collapse);
 
const modules = import.meta.glob("./plugins/**/*.js", { eager: true });
 
for (const path in modules) {
    Alpine.plugin(modules[path].default);
}
 
Alpine.start();

document.addEventListener(
    "alpine:init",
    () => {
        const modules = import.meta.glob("./plugins/**/*.js", { eager: true });
 
        for (const path in modules) {
            window.Alpine.plugin(modules[path].default);
        }
        window.Alpine.plugin(collapse);
        window.Alpine.plugin(anchor);
    },
    { once: true },
);