<?php
// Start a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 1 Workout</title>
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

        .workout-video {
            width: 80%;
            max-width: 600px;
            margin-bottom: 20px;
            display: none; /* Hide videos initially */
        }

        .start-button, .next-button, .finish-button {
            background-color: #007BFF;
            color: white;
            padding: 15px 30px;
            text-transform: uppercase;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            cursor: pointer;
        }

        .start-button:hover, .next-button:hover, .finish-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Day 1 Workout</h1>

    <!-- Workout Video 1 with Start Button -->
    <video id="workoutVideo1" class="workout-video" controls>
        <source src="day1-workout1.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Workout Video 2 -->
    <video id="workoutVideo2" class="workout-video" controls>
        <source src="day1-workout2.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Workout Video 3 -->
    <video id="workoutVideo3" class="workout-video" controls>
        <source src="day1-workout3.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Workout Video 4 -->
    <video id="workoutVideo4" class="workout-video" controls>
        <source src="day1-workout4.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Workout Video 5 -->
    <video id="workoutVideo5" class="workout-video" controls>
        <source src="day1-workout5.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Workout Video 6 -->
    <video id="workoutVideo6" class="workout-video" controls>
        <source src="day1-workout6.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Start Button for Video 1 -->
    <button class="start-button" id="startButton">Start Workout</button>

    <!-- Next Button (to show next video) -->
    <button class="next-button" id="nextButton" style="display: none;">Next Video</button>

    <!-- Finish Button (only visible after all videos are played) -->
    <a href="day2.php" class="finish-button" id="finishButton" style="display: none;">Finish & Next Workout</a>

    <script>
        const videos = [
            document.getElementById('workoutVideo1'),
            document.getElementById('workoutVideo2'),
            document.getElementById('workoutVideo3'),
            document.getElementById('workoutVideo4'),
            document.getElementById('workoutVideo5'),
            document.getElementById('workoutVideo6')
        ];

        const startButton = document.getElementById('startButton');
        const nextButton = document.getElementById('nextButton');
        const finishButton = document.getElementById('finishButton');
        let currentVideoIndex = 0;

        // Function to show the next video
        function showNextVideo() {
            if (currentVideoIndex < videos.length - 1) {
                currentVideoIndex++;
                videos[currentVideoIndex - 1].style.display = 'none'; // Hide the previous video
                videos[currentVideoIndex].style.display = 'block'; // Show the next video
            }

            // If it's the last video, hide the Next button and show Finish button
            if (currentVideoIndex === videos.length - 1) {
                nextButton.style.display = 'none';
                finishButton.style.display = 'block';
            }
        }

        // Add event listener to the Start button
        startButton.addEventListener('click', function() {
            startButton.style.display = 'none'; // Hide the start button
            videos[currentVideoIndex].style.display = 'block'; // Show the first video
            nextButton.style.display = 'block'; // Show the Next button
        });

        // Add event listener to the Next button
        nextButton.addEventListener('click', function() {
            showNextVideo();
        });
    </script>

</body>
</html>
