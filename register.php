<?php
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

// Fetch courses from the database
$courses = [];
$courseQuery = "SELECT name FROM course";
$result = $conn->query($courseQuery);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row['name'];
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $course = $_POST['course'];
    $level = "Beginner"; // Set level to "Beginner" directly
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Get the current date
    $currentDate = date('Y-m-d');

    // Check if the email already exists
    $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        $error_message = "Email already registered. Please use a different email.";
    } else {
        // Prepare the SQL statement to include the date
        $stmt = $conn->prepare("INSERT INTO users (name, weight, height, course, email, password, level, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssssss", $name, $weight, $height, $course, $email, $password, $level, $currentDate);

        // Execute the statement and check if the user is added successfully
        if ($stmt->execute()) {
            // Get the last inserted user ID
            $lastInsertId = $stmt->insert_id;

            // Insert into the day table
            $dayNumber = 0; // Set day_number to 1
            $dayStmt = $conn->prepare("INSERT INTO day (id, date, day_number) VALUES (?, ?, ?)");
            $dayStmt->bind_param("ssi", $lastInsertId, $currentDate, $dayNumber);

            // Execute the day statement
            if (!$dayStmt->execute()) {
                $error_message = "Error inserting into day table: " . $dayStmt->error;
            }

            // Close the day statement
            $dayStmt->close();

            // Registration successful, redirect to the login page
            header("Location: login.php");
            exit(); // Stop further execution after redirect
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Close the check email statement
    $checkEmail->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="regiter.css"> <!-- Link to external CSS file -->
</head>
<body>
    <video autoplay muted loop id="background-video">
        <source src="gy.m4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <div class="container">
        <h2>REGISTER</h2>
        <?php
        if (isset($error_message)) {
            echo "<div class='message'>$error_message</div>";
        } elseif (isset($success_message)) {
            echo "<div class='message success-message'>$success_message</div>";
        }
        ?>
        <form action="register.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="weight">Weight (kg):</label>
            <input type="number" step="0.1" id="weight" name="weight" required>

            <label for="height">Height (cm):</label>
            <input type="number" step="0.01" id="height" name="height" required>

            <label for="course">Course:</label>
            <select id="course" name="course" required>
                <option value="">-- Select a Course --</option>
                <?php
                foreach ($courses as $course) {
                    echo "<option value='$course'>$course</option>";
                }
                ?>
            </select>

            <!-- Removed level selection -->

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="REGISTER">
        </form>
    </div>
</body>
</html>
