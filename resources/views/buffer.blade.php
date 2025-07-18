<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="./assets/vendor/lodash/lodash.min.js"></script>
    <script src="./assets/vendor/dropzone/dist/dropzone-min.js"></script>
    @livewireStyles()

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background-color: #0c0a09;
            color: white;
        }

        .landing-container {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        /* Header */
        .header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background-color: #0c0a09;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Video Wrapper */
        .video-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .bg-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            mask: url(#maskRadial1);
            -webkit-mask: url(#maskRadial1);
        }

        /* Optional radial fade overlay */
        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 90% 50%,
                    /* Highlight on the right */
                    rgba(12, 10, 9, 0) 0%,
                    #0c0a09 80%);
            pointer-events: none;
        }

        /* Content above video */
        .content {
            position: absolute;
            top: 50%;
            left: 10%;
            transform: translateY(-50%);
            z-index: 20;
            max-width: 500px;
        }

        .content h1 {
            font-size: 3rem;
            margin: 0 0 20px;
        }

        .content p {
            font-size: 1.2rem;
            line-height: 1.5;
            opacity: 0.8;
        }

        .content button {
            margin-top: 20px;
            padding: 12px 24px;
            background: #e09f00;
            border: none;
            border-radius: 8px;
            color: black;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .content button:hover {
            background: #ffb300;
        }
    </style>
    </head>

    <body>
        <!-- SVG MASK DEFINITIONS -->
        <svg width="0" height="0">
            <defs>
                <!-- Variation 1: Radial fade (highlight on the right center) -->
                <radialGradient id="videoMaskRadial1" cx="100%" cy="50%" r="150%">
                    <stop offset="0%" stop-color="white" stop-opacity="1" />
                    <stop offset="100%" stop-color="black" stop-opacity="1" />
                </radialGradient>
                <mask id="maskRadial1">
                    <rect width="100%" height="100%" fill="url(#videoMaskRadial1)" />
                </mask>

                <!-- Variation 2: Radial fade (centered highlight) -->
                <radialGradient id="videoMaskRadial2" cx="50%" cy="50%" r="150%">
                    <stop offset="0%" stop-color="white" stop-opacity="1" />
                    <stop offset="100%" stop-color="black" stop-opacity="1" />
                </radialGradient>
                <mask id="maskRadial2">
                    <rect width="100%" height="100%" fill="url(#videoMaskRadial2)" />
                </mask>

                <!-- Variation 3: Radial fade (diagonal highlight top-right) -->
                <radialGradient id="videoMaskRadial3" cx="100%" cy="0%" r="150%">
                    <stop offset="0%" stop-color="white" stop-opacity="1" />
                    <stop offset="100%" stop-color="black" stop-opacity="1" />
                </radialGradient>
                <mask id="maskRadial3">
                    <rect width="100%" height="100%" fill="url(#videoMaskRadial3)" />
                </mask>
            </defs>
        </svg>

        <div class="landing-container">
            <!-- Header -->
            <header class="header">
                My Landing Page
            </header>

            <!-- Video Background -->
            <div class="video-wrapper">
                <video autoplay muted loop playsinline class="bg-video">
                    <source src="{{ asset('videos/shusseki-h264.mp4') }}" type="video/mp4" />
                </video>
                <div class="video-overlay"></div>
            </div>

            <!-- Page Content -->
            <div class="content">
                <h1>Modern Dark Landing</h1>
                <p>
                    This is a modern dark-mode landing page with a radial gradient mask
                    over the background video. The highlight remains on the right, fading
                    into the elegant black background.
                </p>
                <button>Get Started</button>
            </div>
        </div>

    </body>

</html>