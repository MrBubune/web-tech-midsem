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
        <a class="navbar-brand" href="">Sales Management System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
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
        </div>
    </nav>

    <div class="container mt-3">

        <?php
        // Include your database connection file
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

        // Query to analyze data
        $analysisQuery = "SELECT transactions.bookstore_id, bookstores.bookstore_name, COUNT(*) AS total_transactions, SUM(amount) AS total_sales
                          FROM transactions
                          JOIN bookstores ON transactions.bookstore_id = bookstores.bookstore_id
                          GROUP BY transactions.bookstore_id";

        // Fetch data from the database
        $result = mysqli_query($conn, $analysisQuery);

        // Check if there are any records
        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Data Analysis - Bookstores</h2>";

            // Data for charts
            $bookstoreNames = [];
            $totalTransactions = [];
            $totalSales = [];

            // Fetch data for charts
            while ($row = mysqli_fetch_assoc($result)) {
                $bookstoreNames[] = $row['bookstore_name'];
                $totalTransactions[] = $row['total_transactions'];
                $totalSales[] = $row['total_sales'];
            }

            // Display pie chart for total transactions
            echo "<div style='width: 50%; margin: 20px;'>";
            echo "<h4>Total Transactions by Bookstore</h4>";
            echo "<canvas id='transactionsPieChart'></canvas>";
            echo "</div>";

            // Display bar graph for total sales
            echo "<div style='width: 50%; margin: 20px;'>";
            echo "<h4>Total Sales by Bookstore</h4>";
            echo "<canvas id='salesBarGraph'></canvas>";
            echo "</div>";

            // JavaScript for charts
            echo "<script>";
            echo "var transactionsPieChart = new Chart(document.getElementById('transactionsPieChart'), {
                    type: 'pie',
                    data: {
                        labels: " . json_encode($bookstoreNames) . ",
                        datasets: [{
                            data: " . json_encode($totalTransactions) . ",
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                        }]
                    }
                });";

            echo "var salesBarGraph = new Chart(document.getElementById('salesBarGraph'), {
                    type: 'bar',
                    data: {
                        labels: " . json_encode($bookstoreNames) . ",
                        datasets: [{
                            label: 'Total Sales',
                            data: " . json_encode($totalSales) . ",
                            backgroundColor: '#36A2EB',
                            borderColor: '#36A2EB',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });";
            echo "</script>";

            // Display table for transaction details
            echo "<h2>Transaction Details</h2>";
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Transaction ID</th>";
            echo "<th>Customer Name</th>";
            echo "<th>Bookstore Name</th>";
            echo "<th>ISBN</th>";
            echo "<th>Transaction Date</th>";
            echo "<th>Amount</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Query to fetch transaction details
            $transactionDetailsQuery = "SELECT transactions.transaction_id, customers.customer_name, bookstores.bookstore_name, transactions.isbn, transactions.transaction_date, transactions.amount
                                        FROM transactions
                                        JOIN customers ON transactions.customer_id = customers.customer_id
                                        JOIN bookstores ON transactions.bookstore_id = bookstores.bookstore_id";

            $transactionDetailsResult = mysqli_query($conn, $transactionDetailsQuery);

            // Display transaction details in the table
            while ($transaction = mysqli_fetch_assoc($transactionDetailsResult)) {
                echo "<tr>";
                echo "<td>{$transaction['transaction_id']}</td>";
                echo "<td>{$transaction['customer_name']}</td>";
                echo "<td>{$transaction['bookstore_name']}</td>";
                echo "<td>{$transaction['isbn']}</td>";
                echo "<td>{$transaction['transaction_date']}</td>";
                echo "<td>{$transaction['amount']}</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No records found for analysis.";
        }

        // Close the database connection
        mysqli_close($conn);

        
        ?>

    </div>
        

    <!-- Add Bootstrap JS and Popper.js scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
