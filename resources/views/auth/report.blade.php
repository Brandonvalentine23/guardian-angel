<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discharge Page</title>

    <!-- Fonts and Libraries -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

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
            text-decoration: none;
        }

        .sidebar .nav-link:hover {
            background-color: #3949AB; /* Darker blue on hover */
        }

        .main-content {
            margin-left: 220px;
            width: calc(100% - 220px);
            padding: 2rem;
        }

        .form-container {
            background-color: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08);
            max-width: 600px;
            margin: auto;
        }

        .form-container h1 {
            color: #1976D2;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #1976D2;
        }

        .form-container input, .form-container textarea {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .form-container button {
            display: block;
            background-color: #4bb5c5;
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 10px;
            width: 100%;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #1976D2;
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
            <li><a href="{{ route('welcome.MP') }}" class="nav-link">Home</a></li>  
            <li><a href="{{ route('newborn.reg') }}" class="nav-link">Newborn Registration and Pairing</a></li>
            <li><a href="{{ route('motherinfant.pair')}}" class="nav-link">Mother's Registration</a></li>
            <li><a href="{{ route('medicalpersonnel.notifications') }}" class="nav-link">Alerts & Notifications</a></li>
            <li><a href="{{route('medication-administration.index')}}" class="nav-link">Medication Administration</a></li>
             <li><a href="{{ route('logout') }}" class="nav-link">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="form-container">
            <h1>Discharge Patient</h1>
            <form method="POST" action="{{ route('discharge.handle') }}">
                @csrf
                <label for="patient_name">Patient Name</label>
                <input type="text" id="patient_name" name="patient_name" placeholder="Enter patient name" required 
                       style="width: 100%; padding: 0.5rem; border-radius: 10px; border: 1px solid #ccc; margin-bottom: 1rem;">
            
                <label for="rfid_uid">RFID UID</label>
                <input type="text" id="rfid_uid" name="rfid_uid" placeholder="RFID UID will appear here" readonly
                       style="width: 100%; padding: 0.5rem; border-radius: 10px; border: 1px solid #ccc; margin-bottom: 1rem;">
            
                <label for="discharge_date">Discharge Date</label>
                <input type="date" id="discharge_date" name="discharge_date" required
                       style="width: 100%; padding: 0.5rem; border-radius: 10px; border: 1px solid #ccc; margin-bottom: 1rem;">
            
                <label for="notes">Additional Notes</label>
                <textarea id="notes" name="notes" rows="4" placeholder="Optional" 
                          style="width: 100%; padding: 0.5rem; border-radius: 10px; border: 1px solid #ccc; margin-bottom: 1rem;"></textarea>
            
                <button type="button" id="rfid-search-btn" style="margin-top: 1rem; background-color: #4bb5c5; color: white; border: none; padding: 0.75rem; border-radius: 10px; cursor: pointer;">
                    RFID Search
                </button>
                <button type="submit" style="margin-top: 1rem; background-color: #4bb5c5; color: white; border: none; padding: 0.75rem; border-radius: 10px; cursor: pointer;">
                    Submit
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('rfid-search-btn').addEventListener('click', function () {
            alert('Please scan the RFID tag.');
    
            fetch('http://192.168.1.101/get-uid') // Replace with your Raspberry Pi Pico's IP address
                .then(response => response.json())
                .then(data => {
                    if (data.uid) {
                        alert('RFID UID detected: ' + data.uid);
    
                        // Fetch newborn data using the UID
                        return fetch('/rfid-search?uid=' + encodeURIComponent(data.uid));
                    } else {
                        throw new Error('No RFID UID detected.');
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.newborn) {
                        // Populate form fields with the fetched data
                        document.getElementById('patient_name').value = data.newborn.mother_name || 'Not Assigned';
                        document.getElementById('rfid_uid').value = data.newborn.rfid_uid;
                    } else {
                        // If no records are found
                        alert('No records found for this RFID UID.');
                        document.getElementById('patient_name').value = '';
                        document.getElementById('rfid_uid').value = '';
                    }
                })
                .catch(error => {
                    // Handle errors gracefully
                    alert('Error: ' + error.message);
                    document.getElementById('patient_name').value = '';
                    document.getElementById('rfid_uid').value = '';
                });
        });
    </script>
</body>
</html>