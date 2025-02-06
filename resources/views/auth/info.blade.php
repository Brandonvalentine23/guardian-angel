<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newborn and Mother Information</title>
    <!-- Fonts and Libraries -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #E3F2FD; /* Baby blue background */
            font-family: 'Figtree', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 1rem;
        }

        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            width: 100%;
        }

        h1, h2 {
            color: #1976D2;
            margin-bottom: 1rem;
        }

        p {
            margin: 0.5rem 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            padding: 0.75rem;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4bb5c5;
            color: white;
        }

        .back-button {
            margin-top: 2rem;
            display: inline-block;
            background-color: #4bb5c5;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
        }

        .back-button:hover {
            background-color: #3949AB;
        }

        .section {
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Newborn and Mother Information</h1>

        <!-- Newborn Information -->
        <div class="section">
            <h2>Newborn Details</h2>
            <p><strong>Name:</strong> {{ $newborn->newborn_name }}</p>
            <p><strong>Date of Birth:</strong> {{ $newborn->newborn_dob }}</p>
            <p><strong>Gender:</strong> {{ ucfirst($newborn->gender) }}</p>
            <p><strong>Birth Weight:</strong> {{ $newborn->birth_weight }} kg</p>
            <p><strong>Blood Type:</strong> {{ $newborn->blood_type }}</p>
            <p><strong>Health Conditions:</strong> {{ $newborn->health_conditions ?? 'None' }}</p>
            <p><strong>RFID UID:</strong> {{ $newborn->rfid_uid }}</p>
        </div>

        <!-- Mother Information -->
        <div class="section">
            <h2>Mother Details</h2>
            <p><strong>Name:</strong> {{ $newborn->mother->mother_name }}</p>
            <p><strong>Date of Birth:</strong> {{ $newborn->mother->mother_dob }}</p>
            <p><strong>Phone Number:</strong> {{ $newborn->mother->phone_number }}</p>
            <p><strong>Blood Type:</strong> {{ $newborn->mother->blood_type }}</p>
        </div>

        <!-- Medication Administration -->
        <div class="section">
            <h2>Medications</h2>
            @if ($newborn->medicationAdministrations->isEmpty())
                <p>No medications administered to this newborn.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Medication</th>
                            <th>Dose</th>
                            <th>Frequency</th>
                            <th>Route</th>
                            <th>Administered By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newborn->medicationAdministrations as $medication)
                            <tr>
                                <td>{{ $medication->medication_name }}</td>
                                <td>{{ $medication->dose }}</td>
                                <td>{{ $medication->frequency }}</td>
                                <td>{{ $medication->route }}</td>
                                <td>{{ $medication->administered_by }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Back to Dashboard -->
        <a href="{{ route('welcome.MP') }}" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>