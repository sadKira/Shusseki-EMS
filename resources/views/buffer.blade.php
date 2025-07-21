<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="./assets/vendor/lodash/lodash.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
    <script src="./assets/vendor/dropzone/dist/dropzone-min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="./assets/vendor/apexcharts/dist/apexcharts.min.js"></script>
    <script src="./assets/vendor/preline/dist/helper-apexcharts.js"></script>

    <link rel="stylesheet" href="./assets/vendor/apexcharts/dist/apexcharts.css">

    @livewireStyles()

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}


</head>

<body class="bg-black">

    <div class="relative rounded-2xl p-4 text-zinc-100 overflow-hidden" style="
         background: #11100e;
         border: 1px solid rgba(255, 255, 255, 0.06);
         box-shadow:
             inset 1px 1px 2px rgba(255, 255, 255, 0.05),
             0 2px 6px rgba(0, 0, 0, 0.7);
     ">
        <!-- Highlight Overlay -->
        <div class="absolute inset-0 pointer-events-none"
            style="background: linear-gradient(135deg, rgba(255,255,255,0.07), transparent 70%);">
        </div>

        <p class="text-sm text-zinc-400 relative">Events This Week Better</p>
        <p class="text-3xl font-bold text-[#E09F00] relative">8</p>
    </div>

    <div class="relative rounded-2xl p-4 text-zinc-100 overflow-hidden" style="
         background: #18181b;
         border: 1px solid rgba(255, 255, 255, 0.06);
         box-shadow:
             inset 1px 1px 2px rgba(22, 18, 18, 0.05),
             0 2px 6px rgba(0, 0, 0, 0.7);
     ">
        <!-- Highlight Overlay -->
        <div class="absolute inset-0 pointer-events-none"
            style="background: linear-gradient(135deg, rgba(255,255,255,0.07), transparent 70%);">
        </div>

        <p class="text-sm text-zinc-400 relative">Events This Week</p>
        <p class="text-3xl font-bold text-[#E09F00] relative">8</p>
    </div>

    <div class="relative rounded-2xl p-4 text-zinc-100 overflow-hidden" style="
             background: #1C1917;
             border: 1px solid rgba(255, 255, 255, 0.06);
             box-shadow:
                 inset 1px 1px 2px rgba(255, 255, 255, 0.05),
                 0 2px 6px rgba(0, 0, 0, 0.7);
         ">
        <!-- Highlight Overlay -->
        <div class="absolute inset-0 pointer-events-none"
            style="background: linear-gradient(135deg, rgba(255,255,255,0.07), transparent 70%);">
        </div>
        <p class="text-sm text-zinc-400 relative">Events This Week</p>
        <p class="text-3xl font-bold text-[#E09F00] relative">8</p>
    </div>

</body>

</html>