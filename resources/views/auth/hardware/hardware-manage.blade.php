<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Management | Guardian Angels Dashboard</title>

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

        .status-section {
            margin-bottom: 2rem;
        }

        .status-section h4 {
            margin-bottom: 1rem;
        }

        .status {
            font-size: 1.2rem;
            font-weight: bold;
            color: #555;
        }

        .status.on {
            color: green;
        }

        .status.disconnected {
            color: red;
        }

        .rfid-data {
            margin-top: 1rem;
            background-color: #f9f9f9;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .rfid-data p {
            margin: 0.5rem 0;
            color: #555;
        }
    </style>

    <script>
        function checkHardwareStatus() {
            // Dummy logic to simulate hardware status
            const statusElement = document.getElementById('rfid-status');
            const status = Math.random() > 0.5 ? 'on' : 'disconnected';
            
            statusElement.textContent = status === 'on' ? 'RFID Reader is ON' : 'RFID Reader is DISCONNECTED';
            statusElement.className = `status ${status}`;
        }

        // Check status on page load
        window.onload = checkHardwareStatus;
    </script>
</head>
<body>

    <div class="sidebar">
        <h2>GUARDIAN ANGEL</h2>
        <ul>
            <li><a href="{{ route('welcome') }}" class="nav-link">Home</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-map-marker-alt"></i> Location Log </a></li>
            <li><a href="{{ route('newborn.file')}}" class="nav-link"><i class="fas fa-id-card"></i> Newborn Registration Files </a></li>
            <li><a href="{{ route('manage.pair') }}" class="nav-link"><i class="fas fa-users"></i> Paired Mother-Infant Files</a></li>
            <li><a href="{{ route('alert') }}"" class="nav-link"><i class="fas fa-bell"></i> Alerts & Notifications </a></li>
            <li><a href="{{ route('admin.medications') }}" class="nav-link"><i class="fas fa-pills"></i> Medication Administration file </a></li>
            <li><a href="{{ route('report') }}" class="nav-link"><i class="fas fa-cog"></i> Report</a></li>
            <li><a href="{{ route('register.medical') }}" class="nav-link"><i class="fas fa-cog"></i> Medical Personal Registration </a></li>
            <li><a href="{{ route('logout') }}" class="nav-link"><i class="fas fa-cog"></i> Logout </a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container">
            <h2>Hardware Management</h2>

            <div class="status-section">
                <h4>RFID Reader Status:</h4>
                <p id="rfid-status" class="status">Checking...</p>
            </div>

            @php
            $rfidData = [
                (object)[
                    'uid' => 'UID12345',
                    'last_read' => '2024-11-15 12:30:00'
                ],
                (object)[
                    'uid' => 'UID67890',
                    'last_read' => '2024-11-15 15:45:00'
                ],
                (object)[
                    'uid' => 'UID54321',
                    'last_read' => '2024-11-14 08:20:00'
                ]
            ];
            @endphp

            <div class="rfid-data">
                <h4>RFID Data Logs:</h4>
                @foreach($rfidData as $data)
                    <p>UID: {{ $data->uid }}, Last Read: {{ $data->last_read }}</p>
                @endforeach
            </div>
        </div>
    </div>

</body>
</html>