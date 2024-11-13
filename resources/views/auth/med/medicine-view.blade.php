<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardian Angels - Medication Administration</title>

    <!-- Fonts and Tailwind CSS -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->

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

        .form-container {
            background-color: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4bb5c5;
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn-primary {
            background-color: #FF7043;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #E64A19;
        }

        .btn-mad {
            background-color: #4d5ce2;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn-mad:hover {
            background-color: #1c19e6;
        }

        .btn-delete {
            background-color: #c2181e;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn-delete:hover {
            background-color: #ff4800;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
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
            <li><a href="#" class="nav-link"><i class="fas fa-map-marker-alt"></i> Location Tracking</a></li>
            <li><a href="{{ route('newborn.reg') }}" class="nav-link"><i class="fas fa-id-card"></i> Newborn Registration</a></li>
            <li><a href="{{ route('motherinfant.pair') }}" class="nav-link"><i class="fas fa-users"></i> Mother-Infant Pairing</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-bell"></i> Alerts & Notifications</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-pills"></i> Medication Administration</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-cog"></i> Settings</a></li>
            <li><a href="{{ route('logout') }}" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

 <!-- Main Content -->
 <div class="main-content">
    <div class="form-container">
        <h2 class="widget-title">Newborn List</h2>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Date of Birth</th>
                    <th class="px-4 py-2">Medications</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
           <tbody>
    @foreach($newborns as $newborn)
        <tr>
            <td class="border px-4 py-2">{{ $newborn->newborn_name }}</td>
            <td class="border px-4 py-2">{{ $newborn->newborn_dob }}</td>
            <td class="border px-4 py-2">
                @if($newborn->medicationAdministrations->count() > 0)
                    <ul>
                        @foreach($newborn->medicationAdministrations as $medication)
                            <li>
                                {{ $medication->medication_type }} - {{ $medication->dose }} at {{ $medication->administration_time }}
                                @if($medication->done)
                                    <!-- Button for Done Medication -->
                                    <button class="btn-mad" style="background-color: #23e619;">Done</button>
                                @else
                                    <!-- Mark as Done Button -->
                                    <form action="{{ route('medication-administration.markAsDone', $medication->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-mad">Mark as Done</button>
                                    </form>
                                @endif
                                <!-- Delete Button -->
                                <form action="{{ route('medication-administration.delete', $medication->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    No medications recorded.
                @endif
            </td>
            <td class="border px-4 py-2">
                <a href="{{ route('medication-administration.create', ['id' => $newborn->id]) }}" class="btn-primary">Add Medication</a>
            </td>
        </tr>
    @endforeach
</tbody>
        </table>
    </div>
</div>

</body>
</html>