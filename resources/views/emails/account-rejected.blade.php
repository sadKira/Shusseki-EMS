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

    <title>Account Rejected</title>
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
            background: transparent;
            overflow: hidden;
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
            color: #f87171; /* red tone for rejection */
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
            background: #9CA3AF;
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
            background: transparent;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('images/Side_White.svg') }}" alt="Logo">
            <h2>Account Rejected</h2>
        </div>

        <!-- Content -->
        <div class="content">
            <h1>Hello,</h1>
            <p>
                Unfortunately, your account registration has been <strong>rejected</strong>.
            </p>
            <p>
                Common reasons for rejection may include:
            </p>
            <ul>
                <li>Incorrect or incomplete account details</li>
                <li>Not being a currently enrolled student</li>
            </ul>
            <p>
                If you believe this is a mistake or would like to know more, you may approach the <strong>SASO Director</strong> for clarification and assistance.
            </p>
            {{-- <p style="text-align: center;">
                <a href="{{ url('/') }}" class="button">Return to Shusseki</a>
            </p> --}}
        </div>

        <!-- Footer -->
        <div class="footer">
            © {{ date('Y') }} Shusseki EMS. All rights reserved.
        </div>
    </div>
</body>

</html>
