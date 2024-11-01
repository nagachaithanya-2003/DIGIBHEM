<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_banking_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get sender and recipient details
$sender = $_SESSION['username'];
$recipient = $_POST['recipient'];
$amount = $_POST['amount'];

// Check if recipient exists
$recipient_sql = "SELECT * FROM users WHERE username = '$recipient'";
$recipient_result = $conn->query($recipient_sql);

if ($recipient_result->num_rows > 0) {
    // Check if sender has enough balance
    $sender_sql = "SELECT * FROM users WHERE username = '$sender'";
    $sender_result = $conn->query($sender_sql);
    $sender_row = $sender_result->fetch_assoc();

    if ($sender_row['balance'] >= $amount) {
        // Deduct from sender and add to recipient
        $new_sender_balance = $sender_row['balance'] - $amount;
        $new_recipient_balance = $recipient_result->fetch_assoc()['balance'] + $amount;

        $conn->query("UPDATE users SET balance = '$new_sender_balance' WHERE username = '$sender'");
        $conn->query("UPDATE users SET balance = '$new_recipient_balance' WHERE username = '$recipient'");

        // Record the transaction
        $conn->query("INSERT INTO transactions (sender, recipient, amount, date) VALUES ('$sender', '$recipient', '$amount', NOW())");

        // Redirect with success message
        echo "<script>alert('Money transferred successfully!'); window.location.href = 'dashboard.php';</script>";
    } else {
        // Insufficient balance
        echo "<script>alert('Insufficient balance!'); window.location.href = 'dashboard.php';</script>";
    }
} else {
    // Recipient not found
    echo "<script>alert('Recipient not found!'); window.location.href = 'dashboard.php';</script>";
}

$conn->close();
?>
