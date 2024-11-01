<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contact-style.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <a class="navbar-brand" href="dashboard.php"><img src="logo.jpg" alt="Logo"></a>
        <ul>
            <li><a class="nav-link" href="dashboard.php">Home</a></li>
            <li><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Contact Us Form -->
    <div class="contact-container">
        <h1>Contact Us</h1>
        <p>If you have any questions or concerns, please feel free to reach out to us using the form below.</p>

        <form action="contact.php" method="post" class="contact-form">
            <div class="form-group">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="message">Your Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn-submit">Send Message</button>
        </form>
    </div>

    <!-- Handle form submission -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        // Here, you can process the data, e.g., store it in the database or send it via email
        // For now, we'll just show an alert confirming the message is sent
        echo "<script>alert('Thank you, $name. Your message has been sent!');</script>";
    }
    ?>

</body>
</html>
