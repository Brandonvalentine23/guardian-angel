<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Mother-Infant Pairs | Guardian Angels Dashboard</title>

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
            background-color: rgb(255, 255, 255);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            margin: auto;
        }

        h2 {
            font-size: 1.8rem;
            color: #f4f6f7;
            text-align: left;
        }

        h3 {
            font-size: 1.8rem;
            color: #0b0b0b;
            text-align: left;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #f1f1f1;
            font-weight: bold;
        }

        .form-group {
            display: inline-block;
            margin-right: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #4bb5c5;
            color: white;
        }

        .btn-primary:hover {
            background-color: #3B9BA8;
        }

        .btn-danger {
            background-color: #E64A19;
            color: white;
        }

        .btn-danger:hover {
            background-color: #D84315;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>GUARDIAN ANGEL, Admin</h2>
        <ul>
            <li><a href="{{ route('welcome') }}" class="nav-link">Home</a></li>
            <li><a href="{{ route('location.log') }}" class="nav-link"><i class="fas fa-map-marker-alt"></i> Location Log </a></li>            <li><a href="{{ route('newborn.file')}}" class="nav-link"><i class="fas fa-id-card"></i> Newborn Registration Files </a></li>
            <li><a href="{{ route('alert') }}"" class="nav-link"><i class="fas fa-bell"></i> Alerts & Notifications </a></li>
            <li><a href="{{ route('medication-administration.overview') }}" class="nav-link"><i class="fas fa-pills"></i> Medication Administration file </a></li>
            <li><a href="{{ route('report') }}" class="nav-link"><i class="fas fa-cog"></i> Report</a></li>
            <li><a href="{{ route('hardware.manage') }}" class="nav-link"><i class="fas fa-cog"></i> Hardware Management</a></li>
            <li><a href="{{ route('register.medical') }}" class="nav-link"><i class="fas fa-cog"></i> Medical Personal Registration </a></li>
            <li><a href="{{ route('logout') }}" class="nav-link"><i class="fas fa-cog"></i> Logout </a></li>
    </div>

    <div class="main-content">
        <div class="container">
            <h3>Mother-Infant Paired Files</h2>

            <!-- Success message display -->
            @if (session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Table to manage pairs -->
            <table>
                <thead>
                    <tr>
                        <th>Mother Name</th>
                        <th>Newborn Name</th>
                        <th>Date of Birth</th>
                        <th>Edit Pair</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($pairs as $pair)
                    <tr>
                        <!-- Display pair information -->
                        <td>{{ $pair->mother ? $pair->mother->mother_name : 'No Mother Assigned' }}</td>
                        <td>{{ $pair->newborn_name }}</td>
                        <td>{{ $pair->newborn_dob }}</td>
                
                        <!-- Inline edit form for each pair -->
                        <td>
                            <form method="POST" action="{{ route('pairs.update', $pair->id) }}">
                                @csrf
                                <div class="form-group">
                                    <label for="mother_id_{{ $pair->id }}" class="sr-only">Select Mother</label>
                                    <select name="mother_id" id="mother_id_{{ $pair->id }}" required>
                                        @foreach ($mothers as $mother)
                                            <option value="{{ $mother->id }}" 
                                                {{ $pair->mother && $pair->mother->id == $mother->id ? 'selected' : '' }}>
                                                {{ $mother->mother_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </td>
                
                        <!-- Delete button -->
                        <td>
                            <form action="{{ route('pairs.destroy', $pair->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this pair?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No pairs found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>