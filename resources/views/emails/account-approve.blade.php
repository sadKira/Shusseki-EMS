<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Account Approved</title>
  <style>
    /* Use system fonts as Gmail may block Google Fonts */
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, Helvetica, sans-serif;
      background-color: #ffffff; /* white background (safe) */
      color: #333333; /* darker text for readability */
    }

    .container {
      max-width: 600px;
      margin: 30px auto;
      background-color: #ffffff; /* solid white to ensure Gmail displays properly */
      border-radius: 8px;
      overflow: hidden;
      border: 1px solid #e5e7eb;
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
      color: #111111;
      font-weight: 600;
      margin: 0;
      font-size: 20px;
    }

    .content {
      padding: 30px 25px;
      line-height: 1.6;
      font-size: 15px;
      color: #444444;
    }

    .content h1 {
      font-size: 18px;
      margin-bottom: 12px;
      font-weight: 600;
      color: #111111;
    }

    .content p {
      margin: 0 0 20px;
      color: #444444;
    }

    .button {
      display: inline-block;
      padding: 12px 22px;
      background-color: #E7A801;
      color: #000000 !important;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
      font-size: 14px;
    }

    .footer {
      text-align: center;
      padding: 20px;
      font-size: 12px;
      color: #888888;
      border-top: 1px solid #e5e7eb;
      background-color: #ffffff;
    }
  </style>
</head>
<body>
  <div class="container">

    <!-- Header -->
    <div class="header">
      <img src="https://shusseki-ems.site/images/Side_White.svg" alt="Logo" style="display:block;margin:auto;">
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
