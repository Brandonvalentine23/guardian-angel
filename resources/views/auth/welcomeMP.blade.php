<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardian Angels Dashboard</title>

    <!-- Fonts and Libraries -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->

    <!-- Styles -->
    <style>
        body {
            background-color: #E3F2FD; /* Baby blue background */
            font-family: 'Figtree', sans-serif;
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            background-color: #4bb5c5; /* Sidebar color matching theme */
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
            background-color: #3949AB; /* Darker blue on hover */
        }

        .main-content {
            margin-left: 220px;
            width: calc(100% - 220px);
            padding: 2rem;
        }

        .dashboard-header {
            margin-bottom: 2rem;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: white;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.05);
            width: 100%;
            gap: 1rem;
        }

        .search-bar input {
            border: none;
            outline: none;
            flex-grow: 1;
            padding: 0.75rem;
            border-radius: 10px;
        }

        .search-bar button {
            background-color: #4bb5c5;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            color: white;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background-color: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08);
        }

        .widget-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1976D2; /* Dark blue for titles */
        }

        .widget-value {
            font-size: 2.5rem;
            font-weight: 600;
            margin-top: 0.5rem;
            color: #FF7043; /* Orange for widget values */
        }

        .chart-container {
            height: 180px;
        }

        /* Mobile responsiveness adjustments */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            .sidebar {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="text-lg font-semibold">GUARDIAN ANGEL</h2>
        <ul>
            <li><a href="{{ route('motherinfant.pair') }}" class="nav-link">Mother's Registration</a></li>
            <li><a href="{{ route('newborn.reg') }}" class="nav-link">Newborn Registration</a></li>
            <li><a href="{{ route('medication-administration.index') }}" class="nav-link">Medication Administration</a></li>
            <li><a href="{{ route('medicalpersonnel.notifications') }}" class="nav-link">Alerts & Notifications</a></li>
            <li><a href="{{ route('report') }}" class="nav-link">Report</a></li>
            <li><a href="{{ route('logout') }}" class="nav-link">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <div class="search-bar">
                <form method="POST" action="{{ route('rfid.info') }}" style="display: flex; width: 100%;">
                    @csrf
                    <input type="text" id="rfid_uid" name="rfid_uid" placeholder="RFID UID will appear here" readonly>
                    <button type="button" id="rfid-search-btn">Scan RFID</button>
                    <button type="submit" style="background-color: #FF7043;">Search</button>
                </form>
            </div>
        </div>

        <div class="dashboard-grid">
            <!-- Widget: Upcoming Alerts -->
            <div class="card">
                <h2 class="widget-title">Upcoming Alerts</h2>
                <div class="widget-value">{{ $upcomingAlerts }}</div>
                <p>Medications scheduled in the next 10 minutes.</p>
            </div>

            <!-- Widget: Medications Scheduled -->
            <div class="card">
                <h2 class="widget-title">Medications</h2>
                <div class="widget-value">{{ $medicationsScheduled }}</div>
                <p>Medications scheduled for today.</p>
            </div>

            <!-- Widget: Newborn Registrations Chart -->
            <div class="card col-span-3">
                <h2 class="widget-title">Newborn Registrations</h2>
                <canvas id="registrationsChart" class="chart-container"></canvas>
            </div>
        </div>

        <!-- Chart.js Script -->
        <script>
            const registrationCtx = document.getElementById('registrationsChart').getContext('2d');
            const registrationData = {!! json_encode($newbornRegistrations) !!};

            const labels = registrationData.map(item => item.date);
            const counts = registrationData.map(item => item.count);

            new Chart(registrationCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'New Registrations',
                        backgroundColor: '#FF7043',
                        data: counts
                    }]
                },
                options: { responsive: true }
            });
        </script>

        <!-- RFID Script -->
        <script>
            document.getElementById('rfid-search-btn').addEventListener('click', function () {
                alert('Please scan the RFID tag.');
                fetch('http://192.168.1.101/get-uid') // Replace with your Raspberry Pi Pico's IP
                    .then(response => response.json())
                    .then(data => {
                        if (data.uid) {
                            alert('RFID UID detected: ' + data.uid);
                            document.getElementById('rfid_uid').value = data.uid;
                        } else {
                            throw new Error('No RFID UID detected.');
                        }
                    })
                    .catch(error => {
                        alert('Error: ' + error.message);
                    });
            });
        </script>

        <!-- SweetAlert Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let alertsQueue = [];

                // Medication Alerts
                @if (!empty($medicationAlerts) && $medicationAlerts->count() > 0)
                    alertsQueue.push({
                        title: 'Medication Alert',
                        html: `
                            <ul style="text-align: left;">
                                @foreach ($medicationAlerts as $alert)
                                    <li>
                                        <strong>{{ $alert->medication_name }}</strong><br>
                                        Scheduled at: {{ $alert->administration_time }}<br>
                                        Mother: {{ optional($alert->newborn)->mother_name ?? 'Unknown' }}
                                    </li>
                                @endforeach
                            </ul>
                        `,
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        timer: 10000
                    });
                @endif

                // Location Log Alert
                @if (!empty($latestLocationLog))
                    alertsQueue.push({
                        title: 'Location Alert',
                        html: `
                            <ul style="text-align: left;">
                                <li>
                                    <b>UID:</b> {{ $latestLocationLog->uid }}<br>
                                    <b>Location:</b> {{ $latestLocationLog->location }}<br>
                                    <b>Logged At:</b> {{ $latestLocationLog->logged_at }}
                                </li>
                            </ul>
                        `,
                        icon: 'info',
                        confirmButtonText: 'OK',
                        timer: 10000
                    });
                @endif

                function displayAlerts(alerts) {
                    if (alerts.length === 0) return;
                    Swal.fire(alerts.shift()).then(() => displayAlerts(alerts));
                }

                displayAlerts(alertsQueue);
            });
        </script>
    </div>
</body>
</html>