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
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="text-lg font-semibold">GUARDIAN ANGEL</h2>
        <ul>
            <li><a href="{{ route('welcome') }}" class="nav-link">Home</a></li>
            <li><a href="{{ route('newborn.file') }}" class="nav-link">Newborn Registration Files</a></li>
            <li><a href="{{ route('manage.pair') }}" class="nav-link">Paired Mother-Infant</a></li>
            <li><a href="#" class="nav-link">Alerts & Notifications</a></li>
            <li><a href="#" class="nav-link">Medication Administration</a></li>
            <li><a href="{{ route('register.medical') }}" class="nav-link">Medical Personnel Registration</a></li>
            <li><a href="{{ route('logout') }}" class="nav-link">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h2>Newborn Registration Files</h2>
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
                        <th>Newborn Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Birth Weight</th>
                        <th>Blood Type</th>
                        <th>Health Conditions</th>
                        <th>Mother Name</th>
                        <th>Father Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($newborns as $newborn)
                        <tr>
                            <td>{{ $newborn->newborn_name }}</td>
                            <td>{{ $newborn->newborn_dob }}</td>
                            <td>{{ ucfirst($newborn->gender) }}</td>
                            <td>{{ $newborn->birth_weight }} kg</td>
                            <td>{{ $newborn->blood_type ?? 'N/A' }}</td>
                            <td>{{ $newborn->health_conditions ?? 'None' }}</td>
                            <td>{{ $newborn->mother ? $newborn->mother->mother_name : 'No Mother Assigned' }}</td>
                            <td>{{ $newborn->father_name ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No newborn records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>