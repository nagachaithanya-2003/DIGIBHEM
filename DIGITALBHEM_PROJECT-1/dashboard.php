<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.html'); // Redirect to login page if not logged in
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

// Get user details from the database
$user = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $balance = $row['balance'];
    $account_type = $row['account_type']; // 'savings' or 'od'
} else {
    echo "Error fetching user details.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard-style.css"> 
    <title>Dashboard - Online Banking System</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="logo.jpg" alt="Logo" width="100"> 
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Welcome, <?php echo $_SESSION['username']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Welcome to Your Dashboard, <?php echo $_SESSION['username']; ?>!</h1>
                <p>Account Type: <?php echo ucfirst($account_type); ?></p>
                <p>Balance: $<?php echo number_format($balance, 2); ?></p>
            </div>
        </div>

        <div class="row mt-4">
            <!-- User Details Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">User Details</div>
                    <div class="card-body">
                        <p>Username: <?php echo $_SESSION['username']; ?></p>
                        <p>Account Type: <?php echo ucfirst($account_type); ?></p>
                        <p>Balance: $<?php echo number_format($balance, 2); ?></p>
                    </div>
                </div>
            </div>

            <!-- Transfer Amount Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Transfer Amount</div>
                    <div class="card-body">
                        <form action="transfer.php" method="POST">
                            <div class="form-group">
                                <label for="recipient">Recipient Username:</label>
                                <input type="text" class="form-control" id="recipient" name="recipient" required>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount to Transfer:</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Transfer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction History Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Transaction History</div>
                    <div class="card-body">
                        <ul>
                            <?php
                            // Fetch and display transaction history
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            $history_sql = "SELECT * FROM transactions WHERE sender = '$user' OR recipient = '$user' ORDER BY date DESC";
                            $history_result = $conn->query($history_sql);

                            if ($history_result->num_rows > 0) {
                                while ($history_row = $history_result->fetch_assoc()) {
                                    echo "<li>{$history_row['date']} - {$history_row['sender']} sent \${$history_row['amount']} to {$history_row['recipient']}</li>";
                                }
                            } else {
                                echo "<li>No transactions found.</li>";
                            }

                            $conn->close();
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
