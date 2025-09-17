<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <title>{{ $userName }} Attendance Record</title>
    <style>
        body {
            font-family: Hanken Grotesk, sans-serif;
            font-size: 12px;
            margin: 40px;
            color: #000;
        }

        header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        header img {
            height: 60px;
        }

        header .header-text {
            flex: 1;
            text-align: center;
        }

        h1 {
            font-size: 18px;
            margin: 0;
        }

        h2 {
            font-size: 14px;
            margin: 5px 0 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .student-info {
            font-size: 13px;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 10px;
        }

    </style>
</head>

<body>

    <header>
        <div style="text-align: center; margin-bottom: 10px;">
            <img src="{{ public_path('images/MKDGJ.png') }}" alt="Logo" style="height: 70px;">
        </div>
        <div class="header-text">
            <h1>Gakusei Jichikai Stamp Card</h1>
            <h2>School Year {{ $selectedSchoolYear }}</h2>
        </div>
    </header>

    {{-- Student Information --}}
    <table class="student-info" style="width: 100%; margin-bottom: 14px; border-collapse: collapse;" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="text-align: left; vertical-align: top; border: none;">
                <strong>Name:</strong> 
                <span style="border-bottom: 1px solid #000; min-width: 150px;">
                    {{ $user->name }}
                </span>
            </td>
            <td style="text-align: right; vertical-align: top; border: none;">
                <strong>Student ID:</strong> 
                <span style="border-bottom: 1px solid #000; min-width: 150px;">
                    {{ $user->student_id }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="text-align: left; vertical-align: top; border: none;">
                <strong>Year Level:</strong> 
                <span style="border-bottom: 1px solid #000; min-width: 150px;">
                    {{ $user->year_level }}
                </span>
            </td>
            <td style="text-align: right; vertical-align: top; border: none;">
                <strong>Course:</strong>
                <span style="border-bottom: 1px solid #000; min-width: 150px;"> 
                    {{ $user->course }}
                </span>
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-bottom: 14px; border-collapse: collapse;" border="0" cellspacing="0" cellpadding="0" >
        <tr>
            <td style="text-align: left; vertical-align: top;  border: none;">
                <h3 style="margin: 0; line-height: 1.2;">Attendance Summary (A.Y. {{ $selectedSchoolYear }})</h3>
            </td>
            <td style="text-align: right; vertical-align: center;  border: none;">
                <p style="margin: 0; line-height: 1.2;"><strong>Generated on:</strong> {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>
            </td>
        </tr>   
    </table>

    @if($hasEvents)

        {{-- Summary Table --}}
        <table>
            <thead>
                <tr>
                    <th>Total Events</th>
                    <th>Attended (Present + Late)</th>
                    <th>Present</th>
                    <th>Late</th>
                    <th>Absent</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $totalEvents }}</td>
                    <td>{{ $attendedCount }}</td>
                    <td>{{ $presentCount }}</td>
                    <td>{{ $lateCount }}</td>
                    <td>{{ $absentCount }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Main Table --}}
        <div style="position: relative; display: width: 100%; overflow: visible;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        @php
                            $log = $event->attendanceLogs->where('user_id', $user->id)->first();
                        @endphp
                        <tr>
                            
                            <td>{{ $event->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</td>
                            <td>{{ $log?->time_in ? \Carbon\Carbon::parse($log->time_in)->format('h:i A') : '-' }}</td>
                            <td>{{ $log?->time_out ? \Carbon\Carbon::parse($log->time_out)->format('h:i A') : '-' }}</td>

                            <td style="position: relative; text-align: center; overflow: visible; whitespace: nowrap;">
                                {{ $log?->attendance_status->label() ?? 'Absent' }}

                                @if($log && $log->attendance_status->value !== 'absent')
                                    <img src="{{ public_path('images/gj_stamp.png') }}" 
                                        alt="Stamp"
                                        style="position: absolute;
                                            top: 3%;
                                            left: 90%;
                                            width: 40px;
                                            height: 40px;
                                            transform: translate(-50%, -50%) rotate(-12deg);
                                            opacity: 0.85;
                                            pointer-events: none;
                                            z-index: 1;">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else
        <p style="text-align: center; margin-top: 50px; font-weight: bold;">
            No events recorded for the selected school year.
        </p>
    @endif

    <div class="footer">
        <p>Generated by SHUSSEKI Events Management System</p>
    </div>

</body>

</html>