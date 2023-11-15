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

// Calculate Total Sales
$totalSalesQuery = "SELECT SUM(amount) as totalSales FROM transactions";
$totalSalesResult = mysqli_query($conn, $totalSalesQuery);
$totalSales = mysqli_fetch_assoc($totalSalesResult)['totalSales'];

// Sales by Bookstore
$salesByBookstoreQuery = "SELECT bookstore_name, SUM(amount) as totalSales FROM transactions
                         JOIN bookstores ON transactions.bookstore_id = bookstores.bookstore_id
                         GROUP BY bookstore_name";
$salesByBookstoreResult = mysqli_query($conn, $salesByBookstoreQuery);

// Best-selling Products
$bestSellingProductsQuery = "SELECT book_name, COUNT(*) as salesCount FROM transactions
                            JOIN books ON transactions.isbn = books.isbn
                            GROUP BY book_name
                            ORDER BY salesCount DESC
                            LIMIT 5";
$bestSellingProductsResult = mysqli_query($conn, $bestSellingProductsQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Analysis</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Sales Management System</a>
    </nav>

    <div class="container mt-3">

        <!-- Sales Overview Section -->
        <div class="card mb-3">
            <div class="card-header">
                <h3>Sales Overview</h3>
            </div>
            <div class="card-body">
                <p>Total Sales: $
                    <?php echo number_format($totalSales, 2); ?>
                </p>
                <hr>
                <h5>Sales by Bookstore</h5>
                <ul>
                    <?php
                    while ($row = mysqli_fetch_assoc($salesByBookstoreResult)) {
                        echo "<li>{$row['bookstore_name']}: $" . number_format($row['totalSales'], 2) . "</li>";
                    }
                    ?>
                </ul>
                <hr>
                <h5>Best-selling Products</h5>
                <ul>
                    <?php
                    while ($row = mysqli_fetch_assoc($bestSellingProductsResult)) {
                        echo "<li>{$row['book_name']} ({$row['salesCount']} sales)</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Transaction Details Section -->
        <div class="card">
            <div class="card-header">
                <h3>Transaction Details</h3>
            </div>
            <div class="card-body">

                <!-- Search Form -->
                <form action="" method="post" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control"
                            placeholder="Search by Customer ID, Bookstore ID, or ISBN" name="search_term"
                            aria-label="Search" aria-describedby="searchButton">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" id="searchButton">Search</button>
                        </div>
                    </div>
                </form>

                <?php
                // Check if the form is submitted for search
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $searchTerm = mysqli_real_escape_string($conn, $_POST['search_term']);

                    // Construct the search query
                    $searchQuery = "SELECT * FROM transactions
                            WHERE customer_id LIKE '%$searchTerm%'
                            OR bookstore_id LIKE '%$searchTerm%'
                            OR isbn LIKE '%$searchTerm%'
                            ORDER BY transaction_date DESC";

                    $searchResult = mysqli_query($conn, $searchQuery);

                    if (mysqli_num_rows($searchResult) > 0) {
                        echo '<table class="table">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Customer ID</th>
                                <th>Bookstore ID</th>
                                <th>ISBN</th>
                                <th>Transaction Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>';

                        while ($row = mysqli_fetch_assoc($searchResult)) {
                            echo '<tr>
                            <td>' . $row['transaction_id'] . '</td>
                            <td>' . $row['customer_id'] . '</td>
                            <td>' . $row['bookstore_id'] . '</td>
                            <td>' . $row['isbn'] . '</td>
                            <td>' . $row['transaction_date'] . '</td>
                            <td>$' . number_format($row['amount'], 2) . '</td>
                        </tr>';
                        }

                        echo '</tbody></table>';
                    } else {
                        echo '<p>No matching transactions found.</p>';
                    }
                } else {
                    // Retrieve and display all transactions if no search is performed
                    $transactionDetailsQuery = "SELECT * FROM transactions ORDER BY transaction_date DESC";
                    $transactionDetailsResult = mysqli_query($conn, $transactionDetailsQuery);

                    if (mysqli_num_rows($transactionDetailsResult) > 0) {
                        echo '<table class="table">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Customer ID</th>
                                <th>Bookstore ID</th>
                                <th>ISBN</th>
                                <th>Transaction Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>';

                        while ($row = mysqli_fetch_assoc($transactionDetailsResult)) {
                            echo '<tr>
                            <td>' . $row['transaction_id'] . '</td>
                            <td>' . $row['customer_id'] . '</td>
                            <td>' . $row['bookstore_id'] . '</td>
                            <td>' . $row['isbn'] . '</td>
                            <td>' . $row['transaction_date'] . '</td>
                            <td>$' . number_format($row['amount'], 2) . '</td>
                        </tr>';
                        }

                        echo '</tbody></table>';
                    } else {
                        echo '<p>No transactions found.</p>';
                    }
                }
                ?>
            </div>
        </div>

    </div>
    </div>

    </div>

    <!-- Add Bootstrap JS and Popper.js scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>