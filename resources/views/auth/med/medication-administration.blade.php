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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: 600;
            color: #1976D2;
            display: block;
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border-radius: 10px;
            border: 1px solid #ddd;
            outline: none;
        }

        .form-group textarea {
            resize: vertical;
        }

        .btn-primary, .btn-back {
            font-weight: 600;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #FF7043;
            color: white;
        }

        .btn-primary:hover {
            background-color: #E64A19;
        }

        .btn-back {
            background-color: #1976D2;
            color: white;
            margin-bottom: 1rem;
        }

        .btn-back:hover {
            background-color: #1565C0;
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
            <li><a href="{{ route('logout') }}" class="nav-link"><i class="fas fa-cog"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="form-container">
            <h2 class="widget-title">Medication Administration</h2>
            <form action="{{ route('medication-administration.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="newborn_id">Newborn Name</label>
                    <select name="newborn_id" id="newborn_id" required>
                        <option value="">Select Newborn</option>
                        <option value="{{ $newborn->id }}" selected>{{ $newborn->newborn_name }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="medication_type">Medication Type</label>
                    <input type="text" name="medication_type" id="medication_type" required>
                </div>
                <div class="form-group">
                    <label for="administration_time">Administration Time</label>
                    <input type="time" name="administration_time" id="administration_time" required>
                </div>
                <div class="form-group">
                    <label for="dose">Dose</label>
                    <input type="text" name="dose" id="dose" required>
                </div>
                <button type="submit" class="btn-primary">Save</button>
                <a href="{{ route('medication-administration.index') }}" class="btn-back">Back</a> <!-- Back Button -->

            </form>
        </div>
    </div>

</body>
</html>