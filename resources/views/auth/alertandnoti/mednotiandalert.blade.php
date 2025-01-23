<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerts & Notifications | Guardian Angels Dashboard</title>

    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .alert, .notification {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #1976D2;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>GUARDIAN ANGEL Medical Personel</h2>
        <ul>
            <li><a href="{{ route('welcome.MP') }}" class="nav-link">Home</a></li>  
            <li><a href="{{ route('newborn.reg') }}" class="nav-link">Newborn Registration and Pairing</a></li>
            <li><a href="{{ route('motherinfant.pair') }}" class="nav-link">Mother's Registration</a></li>
            <li><a href="{{ route('medicalpersonnel.notifications') }}" class="nav-link">Alerts & Notifications</a></li>
            <li><a href="{{ route('medication-administration.index') }}" class="nav-link">Medication Administration</a></li>
             <li><a href="{{ route('logout') }}" class="nav-link">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h2>Alerts & Notifications</h2>

            <!-- Pending Medications -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h2>Pending Medications</h2>
                </div>
                <div class="card-body">
                    @if ($pendingMedications->count() > 0)
                        <ul>
                            @foreach ($pendingMedications as $medication)
                                <li>
                                    <p><strong>Mother:</strong> {{ optional($medication->newborn)->mother_name ?? 'Unknown' }}</p>
                                    <p><strong>Medication:</strong> {{ $medication->medication_name }}</p>
                                    <p><strong>Scheduled at:</strong> {{ $medication->administration_time }}</p>
                                    <p><strong>Frequency:</strong> {{ $medication->frequency }}</p>
                                    <p><strong>Route:</strong> {{ $medication->route }}</p>
                                    <p><strong>Dose:</strong> {{ $medication->dose }}</p>
                                    <p><strong>Status:</strong> Pending Administration</p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No pending medications at this time.</p>
                    @endif
                </div>
            </div>

            <!-- Upcoming Medications -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h2>Scheduled Medications</h2>
                </div>
                <div class="card-body">
                    @if ($upcomingMedications->count() > 0)
                        <ul>
                            @foreach ($upcomingMedications as $medication)
                                <li>
                                    <p><strong>Medication:</strong> {{ $medication->medication_name }}</p>
                                    <p><strong>Scheduled at:</strong> {{ $medication->administration_time }}</p>
                                    <p><strong>Mother:</strong> {{ optional($medication->newborn)->mother_name ?? 'Unknown' }}</p>
                                    <p><strong>Frequency:</strong> {{ $medication->frequency }}</p>
                                    <p><strong>Route:</strong> {{ $medication->route }}</p>
                                    <p><strong>Dose:</strong> {{ $medication->dose }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No scheduled medications at this time.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 for Notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if ($medicationAlerts->count() > 0)
                Swal.fire({
                    title: 'Medication Alert',
                    html: `
                        <ul style="text-align: left;">
                            @foreach ($medicationAlerts as $alert)
                                <li>
                                    <strong>{{ $alert->medication_name }}</strong><br>
                                    Scheduled at: {{ $alert->administration_time }}<br>
                                    Mother: {{ optional($alert->newborn)->mother_name ?? 'Unknown' }}<br>
                                    Frequency: {{ $alert->frequency }}<br>
                                    Route: {{ $alert->route }}<br>
                                    Dose: {{ $alert->dose }}
                                </li>
                            @endforeach
                        </ul>
                    `,
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 10000 // Auto-close after 10 seconds
                });
            @endif
        });

        // Automatically refresh the page every 60 seconds
        setInterval(function () {
            window.location.reload(); // Reload the current page
        }, 60000); // Refresh every 60 seconds
    </script>
</body>
</html>