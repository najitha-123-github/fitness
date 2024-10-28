<?php
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

// Fetch distinct levels and days from the videos table for dropdowns
$levels = ['Beginner', 'Advance']; // Fixed levels
$days = range(1, 7); // Fixed days 1 to 7

// Handle video addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_workout'])) {
    $videoTitle = $_POST['video_title'];
    $videoFile = $_FILES['video'];
    $videoLevel = $_POST['level'];
    $videoDay = $_POST['day'];

    // Specify the directory to store uploaded videos
    $targetDir = "videos/day2/";
    $targetFile = $targetDir . basename($videoFile["name"]);
    $videoType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Allow only specific file formats
    if ($videoType != "mp4" && $videoType != "avi" && $videoType != "mov") {
        $message = "Sorry, only MP4, AVI & MOV files are allowed.";
    } else {
        // Create the directory if it doesn't exist
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Upload the video file
        if (move_uploaded_file($videoFile["tmp_name"], $targetFile)) {
            // Insert video information into the database
            $stmt = $conn->prepare("INSERT INTO videos (video_title, video_url, level, day) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $videoTitle, $targetFile, $videoLevel, $videoDay);
            
            if ($stmt->execute()) {
                $message = "The video has been uploaded.";
            } else {
                $message = "Error uploading video: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Sorry, there was an error uploading your file.";
        }
    }
}

// Handle video deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_video'])) {
    $videoId = $_POST['video_id'];
    
    // Fetch video URL to delete the file
    $stmt = $conn->prepare("SELECT video_url FROM videos WHERE id = ?");
    $stmt->bind_param("i", $videoId);
    $stmt->execute();
    $stmt->bind_result($videoUrl);
    $stmt->fetch();
    $stmt->close();

    // Delete the video file from the server
    if (file_exists($videoUrl)) {
        unlink($videoUrl);
    }

    // Delete video entry from the database
    $stmt = $conn->prepare("DELETE FROM videos WHERE id = ?");
    $stmt->bind_param("i", $videoId);
    if ($stmt->execute()) {
        $message = "Video deleted successfully.";
    } else {
        $message = "Error deleting video: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch videos based on selected level and day (for display)
$videos = [];
if (isset($_POST['level']) && isset($_POST['day'])) {
    $selectedLevel = $_POST['level'];
    $selectedDay = $_POST['day'];

    $stmt = $conn->prepare("SELECT id, video_title FROM videos WHERE level = ? AND day = ?");
    $stmt->bind_param("ss", $selectedLevel, $selectedDay);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $videos[] = $row;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Workout Videos</title>
    <link rel="stylesheet" href="staffdash.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 50%;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        select, input[type="submit"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .message {
            margin: 10px 0;
            text-align: center;
            color: green;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Manage Workout Videos</h1>

    <?php if (isset($message)): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <h2>Add Video</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="video_title">Video Title:</label>
        <input type="text" name="video_title" id="video_title" required>

        <label for="video">Upload Video:</label>
        <input type="file" name="video" accept="video/mp4,video/x-msvideo,video/All Files" required>

        <label for="level">Select Level:</label>
        <select name="level" id="level" required>
            <option value="">-- Select Level --</option>
            <option value="Beginner">Beginner</option>
            <option value="Advance">Advance</option>
        </select>

        <label for="day">Select Day:</label>
        <select name="day" id="day" required>
            <option value="">-- Select Day --</option>
            <?php for ($i = 1; $i <= 7; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>

        <input type="submit" name="update_workout" value="Add Video">
    </form>

    <h2>Delete Video</h2>
    <form action="" method="post">
        <label for="level">Select Level:</label>
        <select name="level" id="level" required onchange="this.form.submit()">
            <option value="">-- Select Level --</option>
            <?php foreach ($levels as $level): ?>
                <option value="<?php echo htmlspecialchars($level); ?>" <?php echo (isset($selectedLevel) && $selectedLevel == $level) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($level); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="day">Select Day:</label>
        <select name="day" id="day" required onchange="this.form.submit()">
            <option value="">-- Select Day --</option>
            <?php foreach ($days as $day): ?>
                <option value="<?php echo htmlspecialchars($day); ?>" <?php echo (isset($selectedDay) && $selectedDay == $day) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($day); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (!empty($videos)): ?>
        <form action="" method="post">
            <label for="video_id">Select Video to Delete:</label>
            <select name="video_id" id="video_id" required>
                <option value="">-- Select Video --</option>
                <?php foreach ($videos as $video): ?>
                    <option value="<?php echo htmlspecialchars($video['id']); ?>"><?php echo htmlspecialchars($video['video_title']); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="delete_video" value="Delete Video">
        </form>
    <?php else: ?>
        <p>No videos available for the selected Level and Day.</p>
    <?php endif; ?>
</div>

</body>
</html>
