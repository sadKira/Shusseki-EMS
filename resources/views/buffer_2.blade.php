<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @livewireStyles()

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!--HTML CODE-->
    <div class="w-80 relative">
        <div class="swiper multiple-slide-carousel swiper-container relative">
            <div class="swiper-wrapper mb-16">
                <div class="swiper-slide">
                    <div class="bg-indigo-50 rounded-2xl h-56 flex justify-center items-center">
                        <span class="text-2xl font-semibold text-indigo-600">Slide 1 </span>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-indigo-50 rounded-2xl h-56 flex justify-center items-center">
                        <span class="text-2xl font-semibold text-indigo-600">Slide 2 </span>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-indigo-50 rounded-2xl h-56 flex justify-center items-center">
                        <span class="text-2xl font-semibold text-indigo-600">Slide 3 </span>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-indigo-50 rounded-2xl h-56 flex justify-center items-center">
                        <span class="text-2xl font-semibold text-indigo-600">Slide 4 </span>
                    </div>
                </div>
            </div>
            <div class="absolute flex justify-center items-center m-auto left-0 right-0 w-fit bottom-12">
                <button id="slider-button-left"
                    class="swiper-button-prev group !p-2 flex justify-center items-center border border-solid border-indigo-600 !w-12 !h-12 transition-all duration-500 rounded-full  hover:bg-indigo-600 !-translate-x-16"
                    data-carousel-prev>
                    <svg class="h-5 w-5 text-indigo-600 group-hover:text-white" xmlns="http://www.w3.org/2000/svg"
                        width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <button id="slider-button-right"
                    class="swiper-button-next group !p-2 flex justify-center items-center border border-solid border-indigo-600 !w-12 !h-12 transition-all duration-500 rounded-full hover:bg-indigo-600 !translate-x-16"
                    data-carousel-next>
                    <svg class="h-5 w-5 text-indigo-600 group-hover:text-white" xmlns="http://www.w3.org/2000/svg"
                        width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M5.99984 4.00012L10 8.00029L5.99748 12.0028" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>        

</body>

</html>