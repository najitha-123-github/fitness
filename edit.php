<?php
// Start a session
session_start();

// Enable error reporting for debugging (optional for development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
} else {
    echo "User not found.";
    exit;
}

// Update user data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $weight = (float)$_POST['weight'];
    $height = (float)$_POST['height'];
    $level = $_POST['level'];

    // Prepare the SQL statement to update the user data
    $updateStmt = $conn->prepare("UPDATE users SET name = ?, email = ?, weight = ?, height = ?, level = ? WHERE id = ?");
    $updateStmt->bind_param("ssdssi", $name, $email, $weight, $height, $level, $userId);

    if ($updateStmt->execute()) {
        // Show success message using JavaScript and redirect back to edit_profile.php
        echo "<script>
                alert('Profile updated successfully!');
                window.location.href = 'bignner.php'; 
              </script>";
        exit; // Ensure no further code is executed
    } else {
        $error_message = "Error updating profile: " . $updateStmt->error;
    }

    $updateStmt->close();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit.css"> <!-- Link to external CSS -->
</head>
<body>

<div class="container">
    <h2>Edit Profile</h2>
    <?php
    if (isset($error_message)) {
        echo "<div class='error'>$error_message</div>";
    }
    ?>
    <form action="edit_profile.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label for="weight">Weight (kg):</label>
        <input type="number" step="0.1" id="weight" name="weight" value="<?php echo htmlspecialchars($user['weight']); ?>" required>

        <label for="height">Height (cm):</label>
        <input type="number" step="0.1" id="height" name="height" value="<?php echo htmlspecialchars($user['height']); ?>" required>


        <input type="submit" value="Update Profile">
    </form>
</div>

</body>
</html> 
