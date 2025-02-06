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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .status.on {
            color: green;
            font-weight: bold;
        }

        .status.off {
            color: red;
            font-weight: bold;
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
            <li><a href="{{ route('medication-administration.overview') }}" class="nav-link"><i class="fas fa-pills"></i> Medication Administration file </a></li> 
            <li><a href="{{ route('location.log') }}" class="nav-link"><i class="fas fa-map-marker-alt"></i> Location Log </a></li>
            <li><a href="{{ route('alert.admin') }}"class="nav-link"><i class="fas fa-bell"></i> Alerts & Notifications </a></li> 
            <li><a href="{{ route('register.medical') }}" class="nav-link"><i class="fas fa-cog"></i> Medical Personal Registration </a></li>
            <li><a href="{{ route('logout') }}" class="nav-link"><i class="fas fa-cog"></i> Logout </a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container">
            <h2>Hardware Management</h2>

            <!-- Hardware Status -->
            <div class="status-section">
                <h4>Hardware Status:</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Device</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Raspberry Pi Pico</td>
                            <td id="pico-status">Loading...</td>
                        </tr>
                        <tr>
                            <td>Scanning Reader</td>
                            <td id="scanning-reader-status">Loading...</td>
                        </tr>
                        <tr>
                            <td>Main Door Reader</td>
                            <td id="main-door-reader-status">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        async function fetchStatus() {
            try {
                const response = await fetch("http://192.168.1.101/status"); // Replace with actual IP
                const statusData = await response.json();

                // Update the Raspberry Pi Pico status
                const picoStatusElement = document.getElementById('pico-status');
                picoStatusElement.textContent = statusData.pico === 'ON' ? 'Operational' : 'Not Operational';
                picoStatusElement.className = statusData.pico.toLowerCase();

                // Update the Scanning Reader status
                const scanningReaderStatusElement = document.getElementById('scanning-reader-status');
                scanningReaderStatusElement.textContent = statusData.rfid_detection === 'ON' ? 'Operational' : 'Not Operational';
                scanningReaderStatusElement.className = statusData.rfid_detection.toLowerCase();

                // Update the Main Door Reader status
                const mainDoorReaderStatusElement = document.getElementById('main-door-reader-status');
                mainDoorReaderStatusElement.textContent = statusData.rfid_location === 'ON' ? 'Operational' : 'Not Operational';
                mainDoorReaderStatusElement.className = statusData.rfid_location.toLowerCase();
            } catch (error) {
                console.error("Error fetching status:", error);

                // Handle errors by showing an error state
                document.getElementById('pico-status').textContent = "Error";
                document.getElementById('pico-status').className = "off";
                document.getElementById('scanning-reader-status').textContent = "Error";
                document.getElementById('scanning-reader-status').className = "off";
                document.getElementById('main-door-reader-status').textContent = "Error";
                document.getElementById('main-door-reader-status').className = "off";
            }
        }

        // Fetch the status on page load
        fetchStatus();

        // Auto-refresh the status every 10 seconds
        setInterval(fetchStatus, 10000);
    </script>

</body>
</html>