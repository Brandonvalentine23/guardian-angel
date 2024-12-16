<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discharge Report | Guardian Angels Dashboard</title>

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

        .report-section {
            margin-bottom: 2rem;
        }

        .report-section h4 {
            margin-bottom: 1rem;
        }

        .report-section p {
            margin: 0.5rem 0;
            color: #555;
        }

        .button-group {
            text-align: right;
            margin-top: 2rem;
        }

        .print-button {
            padding: 0.75rem 1.5rem;
            background-color: #FF7043;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .print-button:hover {
            background-color: #E64A19;
        }
    </style>

    <script>
        function printReport() {
            window.print();
        }
    </script>
</head>
<body>

    <div class="sidebar">
        <h2>GUARDIAN ANGEL,Admin</h2>
        <ul>
            <li><a href="{{ route('welcome') }}" class="nav-link">Home</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-map-marker-alt"></i> Location Log </a></li>
            <li><a href="{{ route('newborn.file')}}" class="nav-link"><i class="fas fa-id-card"></i> Newborn Registration Files </a></li>
            <li><a href="{{ route('manage.pair') }}" class="nav-link"><i class="fas fa-users"></i> Paired Mother-Infant Files</a></li>
            <li><a href="{{ route('alert') }}"" class="nav-link"><i class="fas fa-bell"></i> Alerts & Notifications </a></li>
            <li><a href="{{ route('medication-administration.overview') }}" class="nav-link"><i class="fas fa-pills"></i> Medication Administration file </a></li>
            <li><a href="{{ route('hardware') }}" class="nav-link"><i class="fas fa-cog"></i> Hardware Management</a></li>
            <li><a href="{{ route('register.medical') }}" class="nav-link"><i class="fas fa-cog"></i> Medical Personal Registration </a></li>
            <li><a href="{{ route('logout') }}" class="nav-link"><i class="fas fa-cog"></i> Logout </a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container">
            <h2>Discharge Report</h2>

            @php
            $motherData = (object)[
                'full_name' => 'Jane Doe',
                'dob' => '1990-05-15',
                'id_card' => '901234567890',
                'phone' => '+60123456789',
                'email' => 'jane.doe@example.com',
                'blood_type' => 'O+',
                'allergies' => 'None',
                'pregnancy_history' => 'No complications'
            ];

            $newbornData = (object)[
                'full_name' => 'Baby Doe',
                'dob' => '2024-11-10',
                'gender' => 'Male',
                'birth_weight' => '3.2 kg',
                'blood_type' => 'O+',
                'health_conditions' => 'Healthy'
            ];

            $healthRecords = [
                'Initial Checkup - Healthy',
                'Follow-up Visit - No issues'
            ];

            $medicationRecords = [
                (object)[
                    'medication' => 'Vitamin K',
                    'time' => '2024-11-10 09:30',
                    'frequency' => 'Single Dose'
                ],
                (object)[
                    'medication' => 'Hepatitis B Vaccine',
                    'time' => '2024-11-11 10:00',
                    'frequency' => 'Single Dose'
                ]
            ];
            @endphp

            <!-- Mother's Data Section -->
            <div class="report-section">
                <h4>Mother's Information</h4>
                <p>Full Name: {{ $motherData->full_name }}</p>
                <p>Date of Birth: {{ $motherData->dob }}</p>
                <p>Identity Card Number: {{ $motherData->id_card }}</p>
                <p>Phone Number: {{ $motherData->phone }}</p>
                <p>Email: {{ $motherData->email }}</p>
                <p>Blood Type: {{ $motherData->blood_type }}</p>
                <p>Allergies: {{ $motherData->allergies }}</p>
                <p>Pregnancy History: {{ $motherData->pregnancy_history }}</p>
            </div>

            <!-- Newborn's Data Section -->
            <div class="report-section">
                <h4>Newborn's Information</h4>
                <p>Full Name: {{ $newbornData->full_name }}</p>
                <p>Date of Birth: {{ $newbornData->dob }}</p>
                <p>Gender: {{ $newbornData->gender }}</p>
                <p>Birth Weight: {{ $newbornData->birth_weight }}</p>
                <p>Blood Type: {{ $newbornData->blood_type }}</p>
                <p>Health Conditions: {{ $newbornData->health_conditions }}</p>
            </div>

            <!-- Health Records Section -->
            <div class="report-section">
                <h4>Health Records</h4>
                @foreach($healthRecords as $record)
                    <p>{{ $record }}</p>
                @endforeach
            </div>

            <!-- Medication Records Section -->
            <div class="report-section">
                <h4>Medication Records</h4>
                @foreach($medicationRecords as $record)
                    <p>Medication: {{ $record->medication }}, Administration Time: {{ $record->time }}, Frequency: {{ $record->frequency }}</p>
                @endforeach
            </div>

            <!-- Print Button -->
            <div class="button-group">
                <button class="print-button" onclick="printReport()">Print Report</button>
            </div>
        </div>
    </div>

</body>
</html>