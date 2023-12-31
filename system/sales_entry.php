<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit;
}
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "creativelearning";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $customer_id = $_POST['customer_id'];
    $bookstore_id = $_POST['bookstore_id'];
    $isbn = $_POST['isbn'];
    $transaction_date = $_POST['transaction_date'];
    $amount = $_POST['amount'];

    // Insert data into the transactions table
    $insertQuery = "INSERT INTO transactions (customer_id, bookstore_id, isbn, transaction_date, amount)
                    VALUES ($customer_id, $bookstore_id, '$isbn', '$transaction_date', $amount)";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        $message = 'Data successfully added to the transactions table.';
    } else {
        $error = 'Error adding data to the transactions table: ' . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Transaction</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="">Creative Learning</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="homepage.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sales_entry.php">Sales Entry</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_database.php">View Database</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_transactions.php">View Transactions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="update_database.php">Update Database</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="data_analysis.php">Data Analysis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
            </ul>
            <!-- Add the Logout button to the left -->
            <form class="form-inline my-2 my-lg-0" action="logout.php" method="post">
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-3">

        <?php if (isset($message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="insert_transaction.php" method="post">
            <h2 class="mb-4">Insert Transaction</h2>

            <div class="form-group">
                <label for="customer_id">Customer ID:</label>
                <input type="text" id="customer_id" name="customer_id" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="bookstore_id">Bookstore ID:</label>
                <input type="text" id="bookstore_id" name="bookstore_id" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="transaction_date">Transaction Date:</label>
                <input type="date" id="transaction_date" name="transaction_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Insert Transaction</button>
        </form>
    </div>

    <!-- Add Bootstrap JS and Popper.js scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>