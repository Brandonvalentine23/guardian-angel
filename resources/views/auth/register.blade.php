<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardian Angels - Register</title>
    <!-- External Fonts and Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background-color: #E3F2FD;
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

        .hidden {
            display: none;
        }
    </style>

    <script>
        function showForm(role) {
            document.getElementById('medical-personnel-form').classList.add('hidden');
            document.getElementById('staff-form').classList.add('hidden');
            if (role === 'medical') {
                document.getElementById('medical-personnel-form').classList.remove('hidden');
            } else if (role === 'staff') {
                document.getElementById('staff-form').classList.remove('hidden');
            }
            document.querySelector('.role-button.active').classList.remove('active');
            document.querySelector('.role-button[data-role="' + role + '"]').classList.add('active');
        }
    </script>
</head>
<body>
    <div class="register-container">
        <h3>Register for Guardian Angels</h3>

        <!-- Role Selection -->
        <div>
            <button class="role-button active" data-role="medical" onclick="showForm('medical')">Medical Personnel</button>
            <button class="role-button" data-role="staff" onclick="showForm('staff')">Staff</button>
        </div>

        <!-- Medical Personnel Registration -->
        <form id="medical-personnel-form" action="{{ route('register.medical') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input id="name" type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="specialization">Specialization</label>
                <input id="specialization" type="text" name="specialization" required>
            </div>
            <div class="form-group">
                <label for="license-number">Medical License Number</label>
                <input id="license-number" type="text" name="license_number" required>
            </div>
            <button type="submit" class="register-button">Register as Medical Personnel</button>
        </form>

        <!-- Staff Registration (Hidden Initially) -->
        <form id="staff-form" class="hidden" action="{{ route('register.staff') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name-staff">Full Name</label>
                <input id="name-staff" type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="email-staff">Email Address</label>
                <input id="email-staff" type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password-staff">Password</label>
                <input id="password-staff" type="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input id="department" type="text" name="department" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="support">Support</option>
                </select>
            </div>
            <button type="submit" class="register-button">Register as Staff</button>
        </form>
    </div>
</body>
</html>