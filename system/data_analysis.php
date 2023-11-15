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

// Convert result set to an array for Doughnut Chart
$salesByBookstoreData = [];
while ($row = mysqli_fetch_assoc($salesByBookstoreResult)) {
    $salesByBookstoreData[] = [
        'bookstore_name' => $row['bookstore_name'],
        'totalSales' => $row['totalSales'],
    ];
}

// Best-selling Products
$bestSellingProductsQuery = "SELECT book_name, COUNT(*) as salesCount FROM transactions
                            JOIN books ON transactions.isbn = books.isbn
                            GROUP BY book_name
                            ORDER BY salesCount DESC
                            LIMIT 5";
$bestSellingProductsResult = mysqli_query($conn, $bestSellingProductsQuery);

// Convert result set to an array for Bar Chart
$bestSellingProductsData = [];
while ($row = mysqli_fetch_assoc($bestSellingProductsResult)) {
    $bestSellingProductsData[] = [
        'book_name' => $row['book_name'],
        'salesCount' => $row['salesCount'],
    ];
}

// Handle sorting options
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'date'; // Default to sorting by date

// Transaction Details Section
if ($sortOption === 'day') {
    $sortQuery = "DAY(transaction_date)";
} elseif ($sortOption === 'month') {
    $sortQuery = "MONTH(transaction_date)";
} else {
    $sortQuery = "transaction_date";
}

// Search Form
$searchForm = '<form action="" method="get" class="mb-3">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search by Customer ID, Bookstore ID, or ISBN" name="search_term" aria-label="Search" aria-describedby="searchButton">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit" id="searchButton">Search</button>
        </div>
    </div>
</form>';

// Construct the query based on the sorting option
$transactionDetailsQuery = "SELECT * FROM transactions ORDER BY $sortQuery DESC";
$transactionDetailsResult = mysqli_query($conn, $transactionDetailsQuery);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Analysis</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        <!-- Sales Overview Section -->
        <div class="card mb-3">
            <div class="card-header">
                <h3>Sales Overview</h3>
            </div>
            <div class="card-body">
                <p>Total Sales: $
                    <?php echo number_format($totalSales, 2); ?>
                </p>
                <!-- Doughnut Chart Section -->
                <div class="mb-3">
                    <canvas id="doughnutChart" width="300" height="300"></canvas>
                </div>

                <hr>
                <h5>Sales by Bookstore</h5>
                <ul>
                    <?php
                    foreach ($salesByBookstoreData as $data) {
                        echo "<li>{$data['bookstore_name']}: $" . number_format($data['totalSales'], 2) . "</li>";
                    }
                    ?>
                </ul>

                <!-- Bar Chart Section -->
                <div class="mt-3">
                    <canvas id="barChart" width="300" height="150"></canvas>
                </div>

                <hr>
                <h5>Best-selling Products</h5>
                <ul>
                    <?php
                    foreach ($bestSellingProductsData as $data) {
                        echo "<li>{$data['book_name']} ({$data['salesCount']} sales)</li>";
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

                <?php echo $searchForm; ?>

                <!-- Sorting Options -->
                <div class="mb-3">
                    <label for="sortSelect">Sort By:</label>
                    <select class="form-control" id="sortSelect" name="sort" onchange="this.form.submit()">
                        <option value="date" <?php echo ($sortOption === 'date') ? 'selected' : ''; ?>>Date</option>
                        <option value="day" <?php echo ($sortOption === 'day') ? 'selected' : ''; ?>>Day</option>
                        <option value="month" <?php echo ($sortOption === 'month') ? 'selected' : ''; ?>>Month</option>
                    </select>
                </div>

                <?php
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
                ?>
            </div>
        </div>

    </div>

    <!-- Add Bootstrap JS and Popper.js scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Doughnut Chart
        var doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
        var doughnutChart = new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_column($salesByBookstoreData, 'bookstore_name')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($salesByBookstoreData, 'totalSales')); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        // Bar Chart
        var barCtx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($bestSellingProductsData, 'book_name')); ?>,
                datasets: [{
                    label: 'Sales Count',
                    data: <?php echo json_encode(array_column($bestSellingProductsData, 'salesCount')); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>