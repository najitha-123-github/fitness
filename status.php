<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day Buttons</title>
    <link rel="stylesheet" href="status.css">
</head>
<body>
    <div class="button-container">
        <!-- Generate buttons for Day 1 to Day 30 -->
        <script>
            for (let i = 1; i <= 30; i++) {
                document.write(`<button class="day-button">Day ${i}</button>`);
            }
        </script>
    </div>
</body>
</html>