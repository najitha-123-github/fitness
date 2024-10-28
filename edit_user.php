<?php
// Include the database connection
include 'db_connect.php';

$id = $_GET['id'];

// Fetch user details by ID
try {
    $query = $db->prepare("SELECT * FROM users WHERE id = ?");
    $query->execute([$id]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    try {
        $query = $db->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
        $query->execute([$username, $email, $role, $id]);
        echo "User updated successfully!";
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
    <title>Edit User</title>
    <link rel="stylesheet" href="manage_users.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Edit User</h1>
        </header>

        <main>
            <?php if ($user): ?>
            <form action="edit_user.php?id=<?php echo $id; ?>" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="staff" <?php echo ($user['role'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
                    <option value="member" <?php echo ($user['role'] == 'member') ? 'selected' : ''; ?>>Member</option>
                </select><br>

                <button type="submit" name="submit">Update User</button>
            </form>
            <?php else: ?>
                <p>User not found.</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
