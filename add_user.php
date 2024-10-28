<?php
// Include your database connection
include 'db_connect.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    try {
        $query = $db->prepare("INSERT INTO users (username, email, role) VALUES (?, ?, ?)");
        $query->execute([$username, $email, $role]);
        echo "User added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link rel="stylesheet" href="manage_users.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Add New User</h1>
        </header>

        <main>
            <form action="add_user.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                    <option value="member">Member</option>
                </select><br>

                <button type="submit" name="submit">Add User</button>
            </form>
        </main>
    </div>
</body>
</html>
