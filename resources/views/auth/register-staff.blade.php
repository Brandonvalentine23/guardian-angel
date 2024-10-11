<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Staff</title>
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

        .form-group input, .form-group select {
            width: 100%;
            padding: 0.75rem;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
        }

        .form-group input:focus, .form-group select:focus {
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

        .back-to-login {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #1976D2;
            text-decoration: none;
        }

        .back-to-login:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h3>Register as Staff</h3>

        <!-- Staff Registration Form -->
        <form method="POST" action="{{ route('register.staff.submit') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input id="name" type="text" name="name" required placeholder="Enter your full name">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" required placeholder="Enter your email">
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
                <label for="department">Department</label>
                <input id="department" type="text" name="department" required placeholder="Enter your department">
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="" disabled selected>Select a role</option>
                    <option value="admin">Admin</option>
                    {{-- <option value="support">Support</option>  --}}
                </select>
            </div>

            <button type="submit" class="register-button">Register as Staff</button>
        </form>

        <a href="{{ route('login') }}" class="back-to-login">Already have an account? Login</a>
    </div>
</body>
</html>