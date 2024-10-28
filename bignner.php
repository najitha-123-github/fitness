<?php
// Start a session
session_start();

// Database connection details
$host = 'localhost';
$dbname = 'registration_db';
$username = 'root';
$password = '';

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Fetch user data
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email, weight, height, level FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['user_level'] = $user['level'];
} else {
    echo "User  not found.";
    exit;
}

$stmt->close();

// Determine the heading based on user level
$heading = $user['level'] === 'Beginner' ? "Beginner's Fitness Training" : "Advance Fitness Training";

// Check for day number click
if (isset($_GET['day'])) {
    $dayNumber = intval($_GET['day']);
    
    // Day 1 is always accessible
    if ($dayNumber == 1) {
        header("Location: day.php?day=" . $dayNumber);
        exit;
    }

    // Check if the previous day exists and its date
    $prevDayNumber = $dayNumber - 1;
    $stmt = $conn->prepare("SELECT date FROM day WHERE day_number = ?");
    $stmt->bind_param("i", $prevDayNumber);
    $stmt->execute();
    $prevDayResult = $stmt->get_result();

    if ($prevDayResult->num_rows > 0) {
        $prevDayData = $prevDayResult->fetch_assoc();
        $currentDate = date('Y-m-d');

        // Check if the previous day is not locked
        if ($prevDayData['date'] == $currentDate) {
            echo "<script>alert('Workout is locked.');</script>";
        } else {
            // Proceed to the selected day page
            header("Location: day.php?day=" . $dayNumber);
            exit;
        }
    } else {
        echo "Previous day not found.";
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $heading; ?></title>
    <link rel="stylesheet" href="bign.css"> <!-- Link to external CSS -->
    <style>
       /* Basic styles for layout */
       body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .heading {
            font-size: 3em;
            margin-bottom: 20px;
            color: #333;
            text-transform: uppercase;
        }

        /* Navigation Bar Styles */
        nav {
            width: 100%;
            background-color: #333;
            padding: 30px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            top: 0;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Profile Section */
        .profile-container {
            position: relative;
            display: inline-block;
            margin: 20px;
        }

        .profile-logo {
            cursor: pointer;
            width: 60px;
            height: 60px;
        }

        .profile-details {
            display: none;
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Display profile details on hover */
        .profile-container:hover .profile-details {
            display: block;
        }

        /* Scrollable container */
        .scroll-container {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            padding: 20px;
            width: 80%;
            position: relative;
            scroll-behavior: smooth;
        }

        /* Day Box */
        .day-box {
            width: 150px;
            height: 150px;
            background-color: #007BFF;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            flex: 0 0 auto; /* Keeps each box in place during scrolling */
        }

        /* Arrow buttons */
        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: #333;
            color: white;
            border: none;
            font-size: 24px;
            cursor: pointer;
            padding: 10px;
            border-radius: 50%;
            opacity: 0.7;
        }

        .scroll-btn.left {
            left: 5px;
        }

        .scroll-btn.right {
            right: 5px;
        }

        .scroll-btn:hover {
            opacity: 1;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <ul class="nav-left">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="status.php">Status</a></li>
        </ul>
    </nav>

    <!-- Heading -->
    <h1 class="heading"><?php echo $heading; ?></h1>
    
    <!-- Profile Section -->
    <div class="profile-container">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile Logo" class="profile-logo" id="profileLogo">
        <div class="profile-details">
            <h2>User Profile</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Weight:</strong> <?php echo htmlspecialchars($user['weight']); ?> kg</p>
            <p><strong>Height:</strong> <?php echo htmlspecialchars($user['height']); ?> m</p>
            <p><strong>Level:</strong> <?php echo htmlspecialchars($user['level']); ?></p>
            <a href="edit.php" class="edit-profile">Edit Profile</a>
        </div>
    </div>

    <!-- Days Section -->
    <div class="scroll-container" id="dayScrollContainer">
        <?php for ($i = 1; $i <= 30; $i++): ?>
            <div class="day-box"><a href="?day=<?php echo $i; ?>" class="day-link">Day <?php echo $i; ?></a></div>
        <?php endfor; ?>
    </div>

    <!-- Scroll Buttons -->
    <button class="scroll-btn left" onclick="scrollLeft()">&#10094;</button>
    <button class="scroll-btn right" onclick="scrollRight()">&#10095;</button>

    <script>
        // JavaScript for scrolling
        function scrollLeft() {
            document.getElementById('dayScrollContainer').scrollBy({ left: -200, behavior: 'smooth' });
        }

        function scrollRight() {
            document.getElementById('dayScrollContainer').scrollBy({ left: 200, behavior: 'smooth' });
        }
    </script>

</body>
</html>
