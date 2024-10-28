<?php
// Include the database connection
include 'db_connect.php';

$id = $_GET['id'];

// Delete the user
try {
    $query = $db->prepare("DELETE FROM users WHERE id = ?");
    $query->execute([$id]);
    echo "User deleted successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
