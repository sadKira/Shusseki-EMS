<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Event Reminder</title>
  <style>
    /* Use system fonts as Gmail may block Google Fonts */
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, Helvetica, sans-serif;
      background-color: #ffffff; /* safe white background */
      color: #333333;
    }

    .container {
      max-width: 600px;
      margin: 30px auto;
      background-color: #ffffff; /* solid white for Gmail */
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

    .event-details {
      background: #f9fafb;
      padding: 15px;
      border-radius: 6px;
      margin: 20px 0;
      border: 1px solid #e5e7eb;
    }

    .event-details p {
      margin: 8px 0;
      color: #333333;
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
      <h2>Upcoming Event Reminder</h2>
    </div>

    <!-- Content -->
    <div class="content">
      <h1>Hi {{ $user->name }},</h1>
      <p>
        This is a friendly reminder that you have an upcoming event scheduled. Here are the details:
      </p>

      <div class="event-details">
        <p><strong>Event:</strong> {{ $event->title }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</p>
        <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
        <p><strong>Location:</strong> {{ $event->location }}</p>
        <p><strong>Attendance Deadline:</strong> {{ \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}</p>
      </div>

      <p style="color:#b91c1c; font-weight:600; margin-top: 15px;">
        ⚠️ Please remember: You must time-in before the deadline.
        Timing-in beyond the set time will automatically mark you as <strong>Late</strong>.
      </p>
    </div>

    <!-- Footer -->
    <div class="footer">
      © {{ date('Y') }} Shusseki EMS. All rights reserved.
    </div>
  </div>
</body>
</html>
