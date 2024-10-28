<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Fitness Training</title>
    <link rel="stylesheet" href="about.css"> <!-- Link to External CSS -->
</head>
<body>
    <!-- Navigation Menu -->
    <nav>
        <ul class="nav-left">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li> <!-- Updated About Link -->
        </ul>
        <ul class="nav-right">
            <li><span>Contact: 7736975433</span></li>
            <li><span>Email: arjunps@gmail.com</span></li>
           
        </ul>
    </nav>

    <!-- About Section -->
    <section id="about" class="about-section">
        <h1>Fitness Training</h1>
        <p>
            Welcome to our Fitness Training program! Our goal is to provide effective and personalized training plans that cater to all fitness levels, from beginners to advanced athletes. Our team of professional trainers is here to guide you every step of the way.
        </p>
        <p>
            Whether you're looking to improve your strength, endurance, flexibility, or overall health, we have the resources to help you achieve your fitness goals. Join us for a transformative experience and take the first step towards a healthier lifestyle!
        </p>

        <!-- PHP block to include the new passage -->
        <?php
        echo '
        <h2> MES College Marampally</h2>
        <p>
            MES College Marampally is a government-aided college affiliated with Mahatma Gandhi University, Kottayam. Established in 1995, the college has been reaccredited by NAAC with an A+ Grade (CGPA, 3.38), the highest grade in the state under the revised accreditation process. The campus, located in a rural area between the towns of Aluva and Perumbavoor, is set in lush green surroundings near the river Periyar and close to Cochin International Airport.
        </p>
        <p>
            The governance and management of the college are anchored in the principles of the Muslim Educational Society (Regd.), Calicut, one of the largest minority educational agencies in Kerala. The college has facilitated new directions in higher education by offering a significant number of vocational and technical programs in tune with the demands of the job market.
        </p>';
        ?>
    </section>
</body>
</html>
