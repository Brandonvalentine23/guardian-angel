<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discharge Details</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #E3F2FD; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); }
        h1, h2 { color: #1976D2; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #4bb5c5; color: white; }
        .section { margin-bottom: 30px; }
        .button-container { text-align: center; margin-top: 20px; }
        .print-button {
            background-color: #4bb5c5;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
        }
        .print-button:hover { background-color: #1976D2; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Discharge Details</h1>

        <!-- Newborn Information -->
        <div class="section">
            <h2>Newborn Information</h2>
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
            <h2>Mother Information</h2>
            <p><strong>Name:</strong> {{ $newborn->mother->mother_name }}</p>
            <p><strong>Date of Birth:</strong> {{ $newborn->mother->mother_dob }}</p>
            <p><strong>Blood Type:</strong> {{ $newborn->mother->blood_type }}</p>
            <p><strong>Phone Number:</strong> {{ $newborn->mother->phone_number }}</p>
        </div>

        <!-- Medication Administration -->
        <div class="section">
            <h2>Medication Administration</h2>
            @if($newborn->medicationAdministrations->isEmpty())
                <p>No medications administered to this newborn.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Medication Name</th>
                            <th>Frequency</th>
                            <th>Route</th>
                            <th>Dose</th>
                            <th>Administered By</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newborn->medicationAdministrations as $medication)
                            <tr>
                                <td>{{ $medication->medication_name }}</td>
                                <td>{{ $medication->frequency }}</td>
                                <td>{{ $medication->route }}</td>
                                <td>{{ $medication->dose }}</td>
                                <td>{{ $medication->administered_by }}</td>
                                <td>{{ $medication->administration_time }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
           <!-- Buttons to Print and Go Back -->
           <div class="button-container">
            
            <a href="{{ route('report') }}" class="button">Back to Report</a>
        </div>
        <!-- Button to Print or Download as PDF -->
        <div class="button-container">
            <button class="print-button" onclick="printPage()">Print as PDF</button>
        </div>
    </div>

    <script>
        function printPage() {
            // Use the browser's print dialog to save as PDF
            window.print();
        }
    </script>
</body>
</html>