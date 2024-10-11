<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Medical Personnel</title>
    <!-- External Fonts and Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #E3F2FD; /* Baby blue background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .register-container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 14px 34px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 600px;
            width: 100%;
        }

        h3 {
            font-size: 2rem;
            font-weight: 600;
            color: #1976D2;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-size: 1rem;
            font-weight: bold;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
        }

        .form-group input:focus {
            border-color: #1976D2;
            box-shadow: 0 0 10px rgba(25, 118, 210, 0.1);
            outline: none;
        }

        .register-button {
            width: 100%;
            padding: 1rem;
            background-color: #4bb5c5;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            cursor: pointer;
            margin-top: 1rem;
            transition: background-color 0.3s;
        }

        .register-button:hover {
            background-color: #3B9BA8;
        }

        .back-to-dash {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #1976D2;
            text-decoration: none;
        }

        .back-to-dash:hover {
            text-decoration: underline;
        }

        /* Success Message Styling */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }

        /* Error Styling */
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h3>Register as Medical Personnel</h3>

        <!-- Display Success Message -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="error-message">{{ $error }}</div>
            @endforeach
        @endif

        <!-- Medical Personnel Registration Form -->
        <form method="POST" action="{{ route('register.medical.submit') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="Enter your full name">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="Enter your email">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required placeholder="Enter your password">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Confirm your password">
            </div>

            <div class="form-group">
                <label for="specialization">Specialization</label>
                <input id="specialization" type="text" name="specialization" value="{{ old('specialization') }}" required placeholder="Enter your specialization">
            </div>

            <div class="form-group">
                <label for="license-number">Medical License Number</label>
                <input id="license-number" type="text" name="license_number" value="{{ old('license_number') }}" required placeholder="Enter your medical license number">
            </div>

            <button type="submit" class="register-button">Register Medical Personnel</button>
        </form>

        <a href="{{ route('welcome') }}" class="back-to-dash"> Back To Dashboard</a>
    </div>
</body>
</html>