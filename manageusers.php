<?php
// Start a session if needed
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

// SQL query to retrieve all users (excluding the password)
$sql = "SELECT id, name, email, course, level, date FROM users";
$result = $conn->query($sql);

// Store users data in an array
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="manageusers.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Manage Users</h1>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">HOME</a></li>
                    <li><a href="manage_users.php">MANAGE USER</a></li>
                    <li><a href="index.php">LOGOUT</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <h2>Users List</h2>
            <a href="add_user.php" class="btn">Add New User</a>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Day</th>
                        <th>Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['course']; ?></td>
                            <td><?php echo $user['date']; ?></td>
                            <td><?php echo ucfirst($user['level']); ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> |
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>

        <footer>
            <p>&copy; 2024 Fitness Training. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
