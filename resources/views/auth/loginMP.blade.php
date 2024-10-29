<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Guardian Angels - Login</title>
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
            height: 100vh;
        }

        .login-container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 14px 34px rgba(0, 0, 0, 0.1);
            display: flex;
            max-width: 1000px;
            width: 90%;
            overflow: hidden;
        }

        .login-left {
            background-color: #4bb5c5;
            padding: 2rem;
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .login-left img {
            max-width: 80%;
            height: auto;
            margin-bottom: 20px;
        }

        .login-left h2 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .login-right {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h3 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 2rem;
            color: #1976D2;
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

        .login-button {
            width: 100%;
            padding: 1rem;
            background-color: #FF7043;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            cursor: pointer;
            margin-top: 1rem;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #E64A19;
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

        .backtoadminlog-button {
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

        .backtoadminlog:hover {
            background-color: #3B9BA8;
        }

        .forgot-password {
            display: block;
            text-align: right;
            margin-top: 10px;
            font-size: 0.9rem;
            color: #1976D2;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-left {
                display: none; /* Hide left panel on mobile */
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Panel (Image and Branding) -->
        <div class="login-left">
            <img src="{{asset('images/Guardian Angel.png')}}" alt="Guardian Angels Logo">
            <h2>Guardian Angels</h2>
        </div>

        <!-- Right Panel (Login Form) -->
        <div class="login-right">
            <h3>Welcome Back!</h3>
            
            <!-- Error Display Section -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Login Form -->
            <form method="POST" action="{{ route('login.MP') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" required autofocus placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div style="display: flex; align-items: center; position: relative;">
                        <!-- Password Input Field -->
                        <input id="password" type="password" name="password" required 
                               placeholder="Enter your password" 
                               style="flex-grow: 1; padding-right: 50px;">
                
                        <!-- Toggle Button with Icon -->
                        <button type="button" id="togglePassword" 
                                style="
                                    position: absolute;
                                    right: 10px;
                                    top: 60%;
                                    transform: translateY(-50%);
                                    border: none;
                                    background: none;
                                    cursor: pointer;
                                    padding: 5px;
                                ">
                            <i class="fas fa-eye" style="font-size: 24px;"></i>
                        </button>
                    </div>
                </div>

                <script>
                    const togglePassword = document.querySelector('#togglePassword');
                    const password = document.querySelector('#password');
                
                    togglePassword.addEventListener('click', function () {
                        // Toggle the password field type
                        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                        password.setAttribute('type', type);
                
                        // Toggle the eye icon between open and closed
                        this.querySelector('i').classList.toggle('fa-eye-slash');
                    });
                </script>

                <a href="{{ route('password.request.MP') }}" class="forgot-password">Forgot Password?</a>

                <!-- Login Button -->
                <button type="submit" class="login-button">Login</button>

                <!-- Back Button to Staff Login -->
                <button class="backtoadminlog-button" onclick="window.location.href='{{ route('login') }}'">Back To Admin Login</button>           
             </form>

        
        </div>
    </div>
</body>
</html>
