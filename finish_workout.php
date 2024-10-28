<?php
session_start();
$host = 'localhost';
$dbname = 'registration_db';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['day']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $day = intval($_POST['day']);
    $day_number = "day" . strval($day); // Ensure day_number is a string with "day" prefix
    $current_date = date("Y-m-d");

    // Insert or update the record in the day table
    $sql = "INSERT INTO day (id, date, day_number) 
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE date = VALUES(date), day_number = VALUES(day_number)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $current_date, $day);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
}
$conn->close();
