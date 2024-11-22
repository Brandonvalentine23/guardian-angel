<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Log | Guardian Angels Dashboard</title>

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

        .log-entry {
            padding: 1rem;
            border-bottom: 1px solid #ddd;
        }

        .log-entry:last-child {
            border-bottom: none;
        }

        .log-entry h4 {
            margin: 0 0 0.5rem;
        }

        .log-entry p {
            margin: 0;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>GUARDIAN ANGEL</h2>
        <ul>
            <li><a href="{{ route('welcome') }}" class="nav-link">Home</a></li>
            <li><a href="{{ route('newborn.file')}}" class="nav-link"><i class="fas fa-id-card"></i> Newborn Registration Files </a></li>
            <li><a href="{{ route('manage.pair') }}" class="nav-link"><i class="fas fa-users"></i> Paired Mother-Infant Files</a></li>
            <li><a href="{{ route('alert') }}"" class="nav-link"><i class="fas fa-bell"></i> Alerts & Notifications </a></li>
            <li><a href="{{ route('admin.medications') }}" class="nav-link"><i class="fas fa-pills"></i> Medication Administration file </a></li>
            <li><a href="{{ route('report') }}" class="nav-link"><i class="fas fa-cog"></i> Report</a></li>
            <li><a href="{{ route('hardware') }}" class="nav-link"><i class="fas fa-cog"></i> Hardware Management</a></li>
            <li><a href="{{ route('register.medical') }}" class="nav-link"><i class="fas fa-cog"></i> Medical Personal Registration </a></li>
            <li><a href="{{ route('logout') }}" class="nav-link"><i class="fas fa-cog"></i> Logout </a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container">
            <h2>Location Log</h2>

            @php
            $locationLogs = [
                (object)[
                    'location_name' => 'room 23',
                    'uid' => 'UID12345',
                    'logged_at' => '2024-11-16 09:30:00',
                ],
                (object)[
                    'location_name' => 'Hospital A',
                    'uid' => 'UID67890',
                    'logged_at' => '2024-11-15 16:45:00',
                ],
                (object)[
                    'location_name' => 'Clinic B',
                    'uid' => 'UID54321',
                    'logged_at' => '2024-11-14 08:20:00',
                ],
            ];
            @endphp

            <!-- Loop through the location logs and display them -->
            @if(empty($locationLogs))
                <p>No location logs available at the moment.</p>
            @else
                @foreach($locationLogs as $log)
                    <div class="log-entry">
                        <h4>Location: {{ $log->location_name }}</h4>
                        <p>UID: {{ $log->uid }}</p>
                        <p>Logged At: {{ $log->logged_at }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</body>
</html>