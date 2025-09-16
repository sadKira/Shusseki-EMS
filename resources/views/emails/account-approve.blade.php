<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/Seal_White.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Hanken Grotesk -->
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <title>Account Approved</title>
    <style>
        body {
            margin: 0;
            font-family: Hanken Grotesk, sans-serif;
            background: linear-gradient(
                to bottom,
                rgba(255, 255, 255, 0.08) 0%,
                rgba(255, 255, 255, 0.02) 30%,
                #0C0A09 100%
            ), #0C0A09;


            color: #e5e7eb;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: transparent; /* fully transparent */
            /* border-radius: 14px; */
            overflow: hidden;
            /* border: 1px solid #2a2f3a; */
        }

        .header {
            text-align: center;
            padding: 25px 20px 15px;
        }

        .header img {
            max-width: 110px;
            margin-bottom: 12px;
        }

        .header h2 {
            color: #ffffff;
            font-weight: 600;
            margin: 0;
        }

        .content {
            padding: 30px 25px;
            line-height: 1.6;
            font-size: 15px;
        }

        .content h1 {
            font-size: 20px;
            margin-bottom: 12px;
            font-weight: 600;
            color: #f9fafb;
        }

        .content p {
            margin: 0 0 20px;
            color: #d1d5db;
        }

        .button {
            display: inline-block;
            padding: 12px 22px;
            background: #E7A801;
            color: #000000 !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #2a2f3a;
            background: transparent; /* keep transparent */
        }
    </style>
</head>

<body>
    <div class="container">

        <?php
        // Use the public path instead of asset() to ensure images are accessible outside the app.
        $imageUrl = public_path('images/Side_White.svg');
        $message->embed($imageUrl, 'Shusseki Logo');
        ?>
        <!-- Header -->
        <div class="header">
            <img src="{{ $message->embed($imageUrl) }}" alt="Logo">
            <h2>Account Approved</h2>
        </div>

        <!-- Content -->
        <div class="content">
            <h1>Hi {{ $user->name }},</h1>
            <p>
                Great news — your account has been <strong>approved</strong> 🎉
            </p>
            <p>
                You can now log in and start exploring everything we’ve prepared for you.
            </p>
            <p style="text-align: center;">
                <a href="{{ url('/') }}" class="button">Visit Shusseki</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            © {{ date('Y') }} Shusseki EMS. All rights reserved.
        </div>
    </div>
</body>

</html>
