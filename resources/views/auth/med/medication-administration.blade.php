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

        .alert-success {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 14px;
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
        <h2 class="text-lg font-semibold">GUARDIAN ANGEL </h2>
        <ul>
            <li><a href="{{ route('welcome.MP') }}" class="nav-link">Home</a></li>  
            <li><a href="{{ route('newborn.reg') }}" class="nav-link"><i class="fas fa-id-card"></i> Newborn Registration and Pairing</a></li>
            <li><a href="{{ route('motherinfant.pair')}}" class="nav-link"><i class="fas fa-users"></i> Mother's Registration</a></li>
            <li><a href="{{ route('medicalpersonnel.notifications') }}" class="nav-link"><i class="fas fa-bell"></i> Alerts & Notifications</a></li>
             <li><a href="{{ route('logout') }}" class="nav-link"><i class="fas fa-cog"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Success Message -->
        @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Errors -->
        @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p style="color: red;">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('medication-administration.store') }}" method="POST">
            @csrf
        
            <!-- Newborn Details -->
            <h2>Newborn Details</h2>
            <div class="form-group">
                <label for="newborn_id">Newborn Name</label>
                <select name="newborn_id" id="newborn_id" class="form-control" required>
                        <option value="{{ $newborn->id }}">{{ $newborn->newborn_name }}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="text" name="dob" id="dob" class="form-control" value="{{ $newborn->newborn_dob ?? '' }}" readonly>
            </div>
            <div class="form-group">
                <label for="birth_weight">Birth Weight</label>
                <input type="text" name="birth_weight" id="birth_weight" class="form-control" value="{{ $newborn->birth_weight ?? '' }}" readonly>
            </div>
            <div class="form-group">
                <label for="gestational_age">Age</label>
                <input type="text" name="gestational_age" id="gestational_age" class="form-control" placeholder="Enter age in weeks" required>
            </div>
        
            <!-- Medication Details -->
            <h2>Medication Details</h2>
            <div class="form-group">
                <label for="medication_name">Medication Name</label>
                <input type="text" name="medication_name" id="medication_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="do">Dosage</label>
                <input type="text" name="dose" id="dose" class="form-control" placeholder="Enter dosage in mg/ml" required>
            </div>
            <div class="form-group">
                <label for="frequency">Frequency</label>
                <input type="text" name="frequency" id="frequency" class="form-control" placeholder="e.g., every 6 hours" required>
            </div>
            <div class="form-group">
                <label for="route">Route of Administration</label>
                <input type="text" name="route" id="route" class="form-control" placeholder="e.g., oral, intravenous" required>
            </div>
            <div class="form-group">
                <label for="administration_time">Administration Time</label>
                <input type="datetime-local" name="administration_time" id="administration_time" class="form-control" required>
            </div>
        
            <!-- Reason for Medication -->
            <h2>Reason for Medication</h2>
            <div class="form-group">
                <label for="diagnosis">Diagnosis/Condition</label>
                <input type="text" name="diagnosis" id="diagnosis" class="form-control" placeholder="Enter diagnosis or condition" required>
            </div>
        
            <!-- Notes and Instructions -->
            <h2>Notes and Instructions</h2>
            <div class="form-group">
                <label for="instructions">Special Instructions</label>
                <textarea name="instructions" id="instructions" class="form-control" rows="4" placeholder="Enter any special instructions"></textarea>
            </div>
        
            <!-- Administered By -->
            <h2>Administered By</h2>
            <div class="form-group">
                <label for="administered_by">Medical Personnel Name</label>
                <input type="text" name="administered_by" id="administered_by" class="form-control" value="{{ Auth::guard('web_mp')->user()->name }}" readonly>                
            </div>
            <button type="submit" class="btn-primary">Save</button>
            <a href="{{ route('medication-administration.index') }}" class="btn-back">Back</a>
        </form>                

    </div>
</body>
</html>