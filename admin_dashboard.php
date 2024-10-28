<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="staffdash.css">
    <style>
        /* Basic styles for the dashboard */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .dashboard-container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding: 35px 0;
            text-align: center;
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 15px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
        }
        .dashboard-summary {
            margin-top: 20px;
            text-align: center; /* Center the entire summary section */
        }
        .dashboard-summary h2 {
            margin-bottom: 20px; /* Add margin below the heading for spacing */
        }
        .summary-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Center the cards */
            gap: 15px;
            max-width: 1000px;      /* Optional: Limit max width for better centering */
            margin: 0 auto;         /* Center the cards container */
        }
        .card {
            background: #007BFF;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            flex: 1;
            min-width: 200px; /* Ensure cards have a minimum width */
            max-width: 300px; /* Ensure cards do not grow too large */
            text-align: center;
        }
        .card button {
            background: #fff;
            color: #007BFF;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }
        .recent-activity {
            margin-top: 30px;
            background: #fff;
            padding: 15px;
            border-radius: 5px;
            text-align: center; /* Center text in recent activity section */
        }
        footer {
            text-align: center;
            padding: 20px 0; /* Adjusted padding for footer */
            background: #333;
            color: #fff;
            margin-top: 30px; /* Reduced margin-top for footer */
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>ADMIN DASHBOARD</h1>
            <nav>
                <ul>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Manage Users</a></li>
                    <li><a href="#">Manage Training</a></li>
                    <li><a href="#">Reports</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <section class="dashboard-summary">
                <h2>Overview</h2>
                <div class="summary-cards">
                    <div class="card">
                        <p>Total Number Of Users</p>
                        <button onclick="location.href='manageusers.php'">View Users</button>
                    </div>
                    <div class="card">
                        <h3>Active Training Programs</h3>
                        <p>Beginners & Advanced</p>
                        <button onclick="location.href='manage_training.php'">Manage Programs</button>
                        <button onclick="location.href='./change_workout.php'">Change Workout</button> <!-- Added Change Workout button -->
                    </div>
                    <div class="card">
                        <h3>New Registrations</h3>
                        <p>Newly Added Users</p>
                        <button onclick="location.href='new_registrations.php'">View Registrations</button>
                    </div>
                </div>
            </section>

            <section class="recent-activity">
                <h2>Recent Activity</h2>
                <ul style="list-style-type: none; padding: 0;">
                    <?php
                    // Sample recent activities (you can replace this with actual database query results)
                    $recentActivities = [
                        "User John Doe registered for 'Advanced Training'",
                        "New program 'Beginner Training' added",
                        "User Jane Smith completed 'Day 3' of 'Intermediate Training'"
                    ];
                    // Loop through and display recent activities
                    foreach ($recentActivities as $activity) {
                        echo "<li>" . htmlspecialchars($activity) . "</li>";
                    }
                    ?>
                </ul>
            </section>
        </main>
        
        <footer>
            <p>&copy; 2024 Fitness Training. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
