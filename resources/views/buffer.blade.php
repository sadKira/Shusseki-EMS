<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metallic Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* ---- Metallic Background Variations ---- */
        .metallic-bg-1 {
            background: radial-gradient(circle at top left,
                    rgba(255, 255, 255, 0.08),
                    rgba(0, 0, 0, 0) 70%),
                linear-gradient(180deg, #0c0a09, #18181b);
        }

        .metallic-bg-2 {
            background: radial-gradient(circle at 30% 20%,
                    rgba(255, 255, 255, 0.05),
                    rgba(0, 0, 0, 0) 60%),
                linear-gradient(135deg, #11100e, #18181b 80%);
        }

        .metallic-bg-3 {
            background: radial-gradient(circle at 70% 30%,
                    rgba(255, 255, 255, 0.04),
                    rgba(0, 0, 0, 0) 60%),
                linear-gradient(180deg, #0c0a09, #131313 90%);
        }

        /* ---- Metallic Card ---- */
        .metallic-card-soft {
            @apply relative rounded-2xl p-5 text-white overflow-hidden;
            background: #11100e;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: inset 1px 1px 2px rgba(255, 255, 255, 0.05),
                0 2px 6px rgba(0, 0, 0, 0.7);
        }

        .metallic-card-soft::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.05) 0%,
                    rgba(255, 255, 255, 0) 40%);
            pointer-events: none;
        }
    </style>
</head>

<body class="metallic-bg-1 min-h-screen text-white">

    <div x-data="{
        tabSelected: 1,
        tabId: $id('tabs'),
        tabButtonClicked(tabButton){
            this.tabSelected = tabButton.id.replace(this.tabId + '-', '');
            this.tabRepositionMarker(tabButton);
        },
        tabRepositionMarker(tabButton){
            this.$refs.tabMarker.style.width=tabButton.offsetWidth + 'px';
            this.$refs.tabMarker.style.height=tabButton.offsetHeight + 'px';
            this.$refs.tabMarker.style.left=tabButton.offsetLeft + 'px';
        },
        tabContentActive(tabContent){
            return this.tabSelected == tabContent.id.replace(this.tabId + '-content-', '');
        },
        tabButtonActive(tabContent){
            const tabId = tabContent.id.split('-').slice(-1);
            return this.tabSelected == tabId;
        }
    }" x-init="tabRepositionMarker($refs.tabButtons.firstElementChild);" class="relative w-full max-w-sm">

        <div x-ref="tabButtons"
            class="relative inline-grid items-center justify-center w-full h-10 grid-cols-3 p-1 text-gray-500 bg-white border border-gray-100 rounded-lg select-none">
            <button :id="$id(tabId)" @click="tabButtonClicked($el);" type="button"
                :class="{ 'bg-gray-100 text-gray-700' : tabButtonActive($el) }"
                class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-sm font-medium transition-all rounded-md cursor-pointer whitespace-nowrap">Tab1</button>
            <button :id="$id(tabId)" @click="tabButtonClicked($el);" type="button"
                :class="{ 'bg-gray-100 text-gray-700' : tabButtonActive($el) }"
                class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-sm font-medium transition-all rounded-md cursor-pointer whitespace-nowrap">Tab2</button>
            <button :id="$id(tabId)" @click="tabButtonClicked($el);" type="button"
                :class="{ 'bg-gray-100 text-gray-700' : tabButtonActive($el) }"
                class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-sm font-medium transition-all rounded-md cursor-pointer whitespace-nowrap">Tab3</button>
            <div x-ref="tabMarker" class="absolute left-0 z-10 w-1/2 h-full duration-300 ease-out" x-cloak>
                <div class="w-full h-full bg-gray-100 rounded-md shadow-sm"></div>
            </div>
        </div>
        <div
            class="relative flex items-center justify-center w-full p-5 mt-2 text-xs text-gray-400 border rounded-md content border-gray-200/70">

            <div :id="$id(tabId + '-content')" x-show="tabContentActive($el)" class="relative">
                This is the content shown for Tab1
            </div>

            <div :id="$id(tabId + '-content')" x-show="tabContentActive($el)" class="relative" x-cloak>
                And, this is the content for Tab2
            </div>

            <div :id="$id(tabId + '-content')" x-show="tabContentActive($el)" class="relative" x-cloak>
                Finally, this is the content for Tab3
            </div>

        </div>
    </div>
</body>

</html>