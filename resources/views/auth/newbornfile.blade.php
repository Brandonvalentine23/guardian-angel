<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newborn Files | Guardian Angels Dashboard</title>

    <!-- Fonts and Tailwind CSS -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    
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

        .container {
            background-color: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08);
            max-width: 1000px;
            margin: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }

        .table th, .table td {
            padding: 0.75rem;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            font-weight: bold;
            color: #1976D2;
        }

        .table td {
            color: #333;
        }

        .btn {
            cursor: pointer;
            display: inline-block;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2 class="text-lg font-semibold">GUARDIAN ANGEL, Admin</h2>
    <ul>
        <li><a href="{{ route('welcome') }}" class="nav-link">Home</a></li>
        <li><a href="{{ route('manage.pair') }}" class="nav-link"><i class="fas fa-users"></i> Paired Mother-Infant Files</a></li>
        <li><a href="{{ route('medication-administration.overview') }}" class="nav-link"><i class="fas fa-pills"></i> Medication Administration file </a></li> 
        <li><a href="{{ route('location.log') }}" class="nav-link"><i class="fas fa-map-marker-alt"></i> Location Log </a></li>
        <li><a href="{{ route('alert.admin') }}"class="nav-link"><i class="fas fa-bell"></i> Alerts & Notifications </a></li> 
        <li><a href="{{ route('hardware.manage') }}" class="nav-link"><i class="fas fa-cog"></i> Hardware Management</a></li>
        <li><a href="{{ route('register.medical') }}" class="nav-link"><i class="fas fa-cog"></i> Medical Personal Registration </a></li>
        <li><a href="{{ route('logout') }}" class="nav-link"><i class="fas fa-cog"></i> Logout </a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <h2>Newborn Registration Files</h2>

        <!-- Search Form -->
        <form action="{{ route('newborn.search') }}" method="GET" class="mb-4">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search newborns..." 
                       class="form-control" style="flex: 1; padding: 0.75rem; border-radius: 10px; border: 1px solid #ccc;">
                <button type="submit" class="btn" 
                        style="background-color: #4bb5c5; color: white; padding: 0.75rem 1.5rem; border-radius: 10px;">
                    Search
                </button>
                <a href="{{ route('newborn.search') }}" class="btn" 
                   style="background-color: #E0E0E0; color: black; padding: 0.75rem 1.5rem; border-radius: 10px; text-decoration: none;">
                    Show All
                </a>
                <button type="button" id="rfid-search-btn" class="btn"
                        style="background-color: #FF7043; color: white; padding: 0.75rem 1.5rem; border-radius: 10px;">
                    Search by RFID
                </button>
            </div>
        </form>

        <!-- Success Message -->
        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        <!-- Newborn Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Birth Weight</th>
                    <th>Blood Type</th>
                    <th>Health Conditions</th>
                    <th>Mother Name</th>
                    <th>RFID UID</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($newborns as $newborn)
                    <tr>
                        <td>{{ $newborn->newborn_name }}</td>
                        <td>{{ $newborn->newborn_dob }}</td>
                        <td>{{ ucfirst($newborn->gender) }}</td>
                        <td>{{ $newborn->birth_weight }} kg</td>
                        <td>{{ $newborn->blood_type }}</td>
                        <td>{{ $newborn->health_conditions ?? 'None' }}</td>
                        <td>{{ $newborn->mother ? $newborn->mother->mother_name : 'No Mother Assigned' }}</td>
                        <td>{{ $newborn->rfid_uid }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No records found for "{{ $search ?? '' }}".</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- RFID Results -->
        <div id="rfid-results-container" style="margin-top: 2rem;"></div>
    </div>
</div>

<script>
    document.getElementById('rfid-search-btn').addEventListener('click', function () {
        const tableBody = document.querySelector('.table tbody'); // Main table body

        alert('Please scan the RFID tag.');
        fetch('http://192.168.1.100/get-uid')  // Replace with your Raspberry Pi Pico's IP address
            .then(response => response.json())
            .then(data => {
                if (data.uid) {
                    alert('RFID UID detected: ' + data.uid);

                    // Fetch newborn data by UID
                    return fetch('/rfid-search?uid=' + encodeURIComponent(data.uid));
                } else {
                    throw new Error('No RFID UID detected.');
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.newborn) {
                    // Clear the table and display only the record associated with the RFID UID
                    tableBody.innerHTML = `
                        <tr>
                            <td>${data.newborn.newborn_name}</td>
                            <td>${data.newborn.newborn_dob}</td>
                            <td>${data.newborn.gender}</td>
                            <td>${data.newborn.birth_weight} kg</td>
                            <td>${data.newborn.blood_type}</td>
                            <td>${data.newborn.health_conditions || 'None'}</td>
                            <td>${data.newborn.mother_name || 'No Mother Assigned'}</td>
                            <td>${data.newborn.rfid_uid}</td>
                        </tr>`;
                } else {
                    // Display a message if no records are found
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="8" class="text-center">No records found for this RFID UID.</td>
                        </tr>`;
                }
            })
            .catch(error => {
                // Handle errors gracefully
                alert('Error: ' + error.message);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center text-danger">Error: ${error.message}</td>
                    </tr>`;
            });
    });
</script>

</body>
</html>