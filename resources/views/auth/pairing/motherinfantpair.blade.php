<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mother-Infant Pairing | Guardian Angels Dashboard</title>

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
            max-width: 600px;
            margin: auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-group input, select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
        }

        .clear-button, .submit-button {
            width: 48%;
            padding: 1rem;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .clear-button {
            background-color: #E0E0E0;
        }

        .submit-button {
            background-color: #FF7043;
            color: white;
        }

        .clear-button:hover {
            background-color: #BDBDBD;
        }

        .submit-button:hover {
            background-color: #E64A19;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
    </style>

    <script>
        function clearForm() {
            document.querySelectorAll('input').forEach(input => input.value = '');
        }
    </script>
</head>
<body>

    <div class="sidebar">
        <h2>GUARDIAN ANGEL</h2>
        <ul>
            <li><a href="{{ route('welcome.MP') }}" class="nav-link">Home</a></li>
            <li><a href="#" class="nav-link">Location Tracking</a></li>
            <li><a href="{{ route('newborn.reg') }}" class="nav-link">Newborn Registration</a></li>
            <li><a href="#" class="nav-link">Alerts & Notifications</a></li>
            <li><a href="#" class="nav-link">Medication Administration</a></li>
            <li><a href="{{ route('logout') }}" class="nav-link">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container">
            <h2>Mother’s Registration</h2>

            <!-- Success Message -->
            @if (session('status'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="error-message">{{ $error }}</div>
                @endforeach
            @endif

            <form method="POST" action="{{ route('mother.submit') }}">
                @csrf

                <div class="form-group">
                    <label>Registration Date and Time</label>
                    <input type="datetime-local" name="registration_datetime" required>
                </div>

                <div class="form-group">
                    <label>Identity Card Number</label>
                    <input type="text" name="identity_card_number" required>
                </div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="mother_name" required>
                </div>

                <div class="form-group">
                    <label>Sex</label>
                    <select name="sex" required>
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="mother_dob" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone_number" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>

                <div class="form-group">
                    <label>Marital Status</label>
                    <select name="marital_status">
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="divorced">Divorced</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Minor Status</label>
                    <input type="checkbox" name="minor_status"> Under 18
                </div>

                <div class="form-group">
                    <label>Blood Type</label>
                    <select name="blood_type">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Allergies</label>
                    <input type="text" name="allergies">
                </div>

                <div class="form-group">
                    <label>Pregnancy History</label>
                    <input type="text" name="pregnancy_history">
                </div>

                <div class="button-group">
                    <button type="button" class="clear-button" onclick="clearForm()">Clear</button>
                    <button type="submit" class="submit-button">Submit</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>