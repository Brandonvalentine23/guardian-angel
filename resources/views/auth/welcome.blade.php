<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardian Angels Dashboard</title>

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
        }

        .sidebar .nav-link:hover {
            background-color: #3949AB; /* Darker blue on hover */
        }

        .main-content {
            margin-left: 220px;
            width: calc(100% - 220px);
            padding: 2rem;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background-color: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08);
        }

        .widget-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1976D2; /* Dark blue for titles */
        }

        .widget-value {
            font-size: 2.5rem;
            font-weight: 600;
            margin-top: 0.5rem;
            color: #FF7043; /* Orange for widget values */
        }

        .chart-container {
            height: 180px;
        }

        .circular-chart {
            height: 150px;
            width: 150px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            border-radius: 20px;
            background-color: white;
            box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.05);
            padding: 0.75rem;
            grid-column: span 3;
            margin-bottom: 2rem;
        }

        .search-bar input {
            border: none;
            outline: none;
            flex-grow: 1;
            padding: 0.5rem;
            border-radius: 10px;
        }

        .search-bar button {
            background-color: #FF7043;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            color: white;
        }

        /* Mobile responsiveness adjustments */
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
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
        <h2 class="text-lg font-semibold">GUARDIAN ANGEL, Admin</h2>
        <ul>
            <li><a href="{{ route('newborn.file')}}" class="nav-link"><i class="fas fa-id-card"></i> Newborn Registration Files </a></li>
            <li><a href="{{ route('manage.pair') }}" class="nav-link"><i class="fas fa-users"></i> Paired Mother-Infant Files</a></li>
            <li><a href="{{ route('medication-administration.overview') }}" class="nav-link"><i class="fas fa-pills"></i> Medication Administration file </a></li> 
            <li><a href="{{ route('location.log') }}" class="nav-link"><i class="fas fa-map-marker-alt"></i> Location Log </a></li>
            <li><a href="{{ route('alert.admin') }}"class="nav-link"><i class="fas fa-bell"></i> Alerts & Notifications </a></li> 
            <li><a href="{{ route('hardware.manage') }}" class="nav-link"><i class="fas fa-cog"></i> Hardware Management</a></li>
            <li><a href="{{ route('register.medical') }}" class="nav-link"><i class="fas fa-cog"></i> Medical Personal Registration </a></li>
            <li><a href="{{ route('logout') }}" class="nav-link"><i class="fas fa-cog"></i> Logout </a></li>
        </ul>
    
    </div>

    <!-- Main Content -->


    <div class="main-content">
        <div class="dashboard-grid">
         

            <!-- Card 1 (Example Data) -->
            <div class="card">
                <h2 class="widget-title">Active Alerts</h2>
                <div class="widget-value">3</div>
                <p>Active emergency notifications.</p>
            </div>

            <!-- Card 2 (Example Data) -->
            <div class="card">
                <h2 class="widget-title">Medications</h2>
                <div class="widget-value">15</div>
                <p>Scheduled for today.</p>
            </div>

            <!-- Card 3 with Circular Chart (Progress) -->
            <div class="card">
                <h2 class="widget-title">Tracking Progress</h2>
                <canvas id="progressChart" class="circular-chart"></canvas>
            </div>

            <!-- Line Chart (Location Data) -->
            <div class="card col-span-2">
                <h2 class="widget-title">Tracking Data</h2>
                <canvas id="lineChart" class="chart-container"></canvas>
            </div>

            <!-- Pie Chart (Alerts Breakdown) -->
            <div class="card">
                <h2 class="widget-title">Alerts Breakdown</h2>
                <canvas id="revenueChart" class="chart-container"></canvas>
            </div>

           <!-- Newborn Registrations Widget -->
        <div class="card col-span-3">
            <h2 class="widget-title">Newborn Registrations</h2>
            <canvas id="barChart" class="chart-container"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('barChart').getContext('2d');

        // Fetch data from the backend
        fetch('/api/newborn/registrations')
            .then(response => response.json())
            .then(data => {
                // Extract dates and counts from the response
                const labels = data.map(item => item.date);
                const counts = data.map(item => item.count);

                // Render the bar chart using Chart.js
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Newborn Registrations',
                            data: counts,
                            backgroundColor: 'rgba(75, 181, 197, 0.5)',
                            borderColor: 'rgba(75, 181, 197, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching newborn registration data:', error));
    });
</script>
    <!-- Chart.js configuration -->
    <script>
        // Circular Chart (Progress)
        const progressCtx = document.getElementById('progressChart').getContext('2d');
        const progressChart = new Chart(progressCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tracked', 'Not Tracked'],
                datasets: [{
                    data: [85, 15],
                    backgroundColor: ['#FF7043', '#E3F2FD'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Line Chart (Location Tracking Data)
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Tracked Locations',
                    borderColor: '#1976D2',
                    data: [50, 60, 55, 70, 80, 75],
                    fill: false,
                }]
            },
            options: { responsive: true }
        });

        // Pie Chart (Alerts Breakdown)
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'pie',
            data: {
                labels: ['Critical', 'Warning', 'Normal'],
                datasets: [{
                    data: [10, 20, 70],
                    backgroundColor: ['#FF7043', '#64B5F6', '#E57373']
                }]
            },
            options: { responsive: true }
        });

        // Bar Chart (Newborn Registrations)
        const barCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [{
                    label: 'New Registrations',
                    backgroundColor: '#FF7043',
                    data: [10, 20, 30, 40, 50]
                }]
            },
            options: { responsive: true }
        });
    </script>
</body>
</html>
