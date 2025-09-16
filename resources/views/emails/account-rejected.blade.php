<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Account Rejected</title>
  <style>
    /* Use system fonts as Gmail may block Google Fonts */
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, Helvetica, sans-serif;
      background-color: #ffffff; /* safe background */
      color: #333333; /* safe text */
    }

    .container {
      max-width: 600px;
      margin: 30px auto;
      background-color: #ffffff; /* solid white background */
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
      margin-bottom: 20px;
    }

    .header h2 {
      color: #DC2626; /* red tone for rejection */
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

    .content ul {
      margin: 0 0 20px 20px;
      padding: 0;
      color: #444444;
    }

    .content li {
      margin-bottom: 8px;
    }

    .button {
      display: inline-block;
      padding: 12px 22px;
      background-color: #9CA3AF;
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
      <img src="https://shusseki-ems.site/images/Side_White.png" alt="Logo">
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
      <!-- Optional button (currently commented out in original) -->
      <!--
      <p style="text-align: center;">
        <a href="{{ url('/') }}" class="button">Return to Shusseki</a>
      </p>
      -->
    </div>

    <!-- Footer -->
    <div class="footer">
      © {{ date('Y') }} Shusseki EMS. All rights reserved.
    </div>
  </div>
</body>
</html>
