<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerts & Notifications | Guardian Angels Dashboard</title>

    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #E3F2FD;
            font-family: 'Figtree', sans-serif;
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            background-color: #4bb5c5;
            color: white;
            width: 200px;
            min-height: 100vh;
            padding: 1.5rem 1rem;
            border-radius: 20px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar .nav-link {
            margin-bottom: 1.5rem;
            color: white;
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 10px;
            transition: background-color 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: #3949AB;
        }

        .main-content {
            margin-left: 220px;
            width: calc(100% - 220px);
            padding: 2rem;
        }

        .container {
            background-color: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            margin: auto;
        }

        .alert-section, .notification-section {
            margin-bottom: 2rem;
        }

        .alert-section h4, .notification-section h4 {
            margin-bottom: 1rem;
        }

        .alert, .notification {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .alert {
            background-color: #FFCDD2;
            color: #C62828;
        }

        .notification {
            background-color: #FFF9C4;
            color: #F57F17;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>GUARDIAN ANGEL</h2>
        <ul>
            <li><a href="{{ route('welcome') }}" class="nav-link">Home</a></li>
            <li><a href="{{ route('view.locationRoute') }}" class="nav-link"><i class="fas fa-map-marker-alt"></i> Location Log </a></li>
            <li><a href="{{ route('newborn.file')}}" class="nav-link"><i class="fas fa-id-card"></i> Newborn Registration Files </a></li>
            <li><a href="{{ route('manage.pair') }}" class="nav-link"><i class="fas fa-users"></i> Paired Mother-Infant Files</a></li>
            <li><a href="{{ route('admin.medications') }}" class="nav-link"><i class="fas fa-pills"></i> Medication Administration file </a></li>
            <li><a href="{{ route('report') }}" class="nav-link"><i class="fas fa-cog"></i> Report</a></li>
            <li><a href="{{ route('hardware') }}" class="nav-link"><i class="fas fa-cog"></i> Hardware Management</a></li>
            <li><a href="{{ route('register.medical') }}" class="nav-link"><i class="fas fa-cog"></i> Medical Personal Registration </a></li>
            <li><a href="{{ route('logout') }}" class="nav-link"><i class="fas fa-cog"></i> Logout </a></li>
        </ul>
        </ul>
    </div>

    <div class="main-content">
        <div class="container">
            <h2>Alerts & Notifications</h2>

            <!-- Alerts Section -->
            <div class="alert-section">
                <h4>Location Alerts</h4>
                @php
                $locationAlerts = [
                    (object)[
                        'room' => 'Room A',
                        'uid' => 'UID12345',
                        'timestamp' => '2024-11-16 10:15:00',
                        'event' => 'Entered'
                    ],
                    (object)[
                        'room' => 'Exit Gate',
                        'uid' => 'UID67890',
                        'timestamp' => '2024-11-16 14:30:00',
                        'event' => 'Exited'
                    ]
                ];
                @endphp

                @foreach($locationAlerts as $alert)
                    <div class="alert">
                        <strong>Alert:</strong> RFID Tag {{ $alert->uid }} {{ $alert->event }} {{ $alert->room }} at {{ $alert->timestamp }}
                    </div>
                @endforeach
            </div>

            <!-- Notifications Section -->
            <div class="notification-section">
                <h4>Medication Administration Notifications</h4>
                @php
                $medicationNotifications = [
                    (object)[
                        'medication' => 'Vitamin K',
                        'time' => '2024-11-16 12:00:00',
                        'notification_time' => '2024-11-16 11:45:00'
                    ],
                    (object)[
                        'medication' => 'Hepatitis B Vaccine',
                        'time' => '2024-11-17 09:00:00',
                        'notification_time' => '2024-11-17 08:45:00'
                    ]
                ];
                @endphp

                @foreach($medicationNotifications as $notification)
                    <div class="notification">
                        <strong>Notification:</strong> Medication {{ $notification->medication }} needs to be administered at {{ $notification->time }}. Reminder sent at {{ $notification->notification_time }}.
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</body>
</html>