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

// Fetch transactions from the database
$query = "SELECT * FROM transactions";
$result = mysqli_query($conn, $query);

// Check if there are any transactions
if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Transactions</title>
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
            <h2>View Transactions</h2>

            <table class="table">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Customer Name</th>
                        <th>Purchase Details</th>
                        <th>Transaction Date</th>
                        <th>Store ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through each row of the result set
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['transaction_id']}</td>";
                        echo "<td>{$row['customer_id']}</td>";
                        echo "<td>{$row['bookstore_id']}</td>";
                        echo "<td>{$row['isbn']}</td>";
                        echo "<td>{$row['transaction_date']}</td>";
                        echo "<td>{$row['amount']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Add Bootstrap JS and Popper.js scripts here -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

    </html>
    <?php
} else {
    echo "No transactions found.";
}

// Close the database connection
mysqli_close($conn);
?>