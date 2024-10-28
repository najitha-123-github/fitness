<?php
// Start the session
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

// Fetch workout details for Day 1 without video URL
$stmt = $conn->prepare("SELECT title, description FROM workouts WHERE day = 1");
$stmt->execute();
$stmt->bind_result($title, $description);
$stmt->fetch();
$stmt->close();

// Fetch video URL for Day 1 workout from videos table (if stored separately)
$stmt = $conn->prepare("SELECT video_url FROM videos WHERE workout_id = 1"); // Adjust workout_id as needed
$stmt->execute();
$stmt->bind_result($videoUrl);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 1 Workout</title>
    <link rel="stylesheet" href="day1.css">
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($title); ?></h1>
        <p><?php echo htmlspecialchars($description); ?></p>

        <?php if ($videoUrl): ?>
            <div class="video-container">
                <video width="600" controls>
                    <source src="<?php echo htmlspecialchars($videoUrl); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php else: ?>
            <p>No video available for this workout.</p>
        <?php endif; ?>

        <form action="next_day.php" method="post">
            <input type="submit" value="Go to Day 2">
        </form>
    </div>
</body>
</html>
