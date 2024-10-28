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

// Get the day parameter from the URL
$day = isset($_GET['day']) ? intval($_GET['day']) : 1;

// Get user level from session
$user_level = $_SESSION['user_level'];

// Fetch videos for the selected day and user level from the database
$stmt = $conn->prepare("SELECT video_title, video_url FROM videos WHERE day = ? AND level = ?");
$stmt->bind_param("is", $day, $user_level); // Assuming level is a string
$stmt->execute();
$result = $stmt->get_result();

// Store videos in an array
$videos = [];
while ($row = $result->fetch_assoc()) {
    $videos[] = $row;
}

$stmt->close();

// Ensure there are videos for the selected day
if (empty($videos)) {
    echo "No videos found for this day.";
    exit;
}

// Determine current video index based on user input
$currentVideoIndex = isset($_GET['video']) ? intval($_GET['video']) : 0;
$totalVideos = count($videos);

// Ensure the current video index is within bounds
if ($currentVideoIndex < 0 || $currentVideoIndex >= $totalVideos) {
    echo "Invalid video index.";
    exit;
}

// Prepare to play the current video
$currentVideo = $videos[$currentVideoIndex]['video_url'];
$currentVideoTitle = $videos[$currentVideoIndex]['video_title'];
$nextVideoIndex = $currentVideoIndex + 1;
$nextVideoLink = $nextVideoIndex < $totalVideos ? "day.php?day=$day&video=$nextVideoIndex" : "javascript:void(0);"; // Last video will trigger finish
$buttonText = $nextVideoIndex < $totalVideos ? "Next" : "Finish";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($currentVideoTitle); ?></title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .video-container {
            margin-bottom: 20px;
        }
        video {
            width: 600px; /* Adjust width as necessary */
            height: auto;
        }
        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 600px; /* Same as video width */
            margin-top: 20px;
        }
        .nav-button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .nav-button:hover {
            background-color: #0056b3;
        }
        h1 {
            margin-bottom: 20px;
        }
    </style>
    <script>
        function finishWorkout() {
            // Send an AJAX request to finish the workout
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "finish_workout.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("You have finished Day <?php echo $day; ?> workout successfully!");
                    window.location.href = 'bignner.php';
                }
            };
            xhr.send("day=<?php echo $day; ?>");
        }
    </script>
</head>
<body>

    <h1><?php echo htmlspecialchars($currentVideoTitle); ?></h1>
    
    <div class="video-container">
        <video controls>
            <source src="<?php echo htmlspecialchars($currentVideo); ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <div class="navigation-buttons">
        <?php if ($currentVideoIndex > 0): ?>
            <a href="day.php?day=<?php echo $day; ?>&video=<?php echo $currentVideoIndex - 1; ?>" class="nav-button">Previous</a>
        <?php endif; ?>
        <a href="<?php echo $nextVideoLink; ?>" class="nav-button" onclick="<?php if ($nextVideoIndex >= $totalVideos) echo 'finishWorkout();'; else echo 'location.href=\'' . $nextVideoLink . '\';'; ?>">
            <?php echo $buttonText; ?>
        </a>
    </div>

</body>
</html>
