<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Destroy the session to log out the user
    session_destroy();

    // Redirect to login page after logging out
    header("Location: login.php?loggedout=true");
    exit;
} else {
    // If no session exists, redirect to login page directly
    header("Location: login.php");
    exit;
}
?>
<?php
if (isset($_GET['loggedout']) && $_GET['loggedout'] == 'true') {
    echo "<p style='color: green;'>You have been logged out successfully.</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="staffdashboard.php">Dashboard</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
