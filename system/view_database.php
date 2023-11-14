<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tables</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        // Function to display a table
        function displayTable($title, $query, $conn)
        {
            echo "<h2>$title</h2>";

            // Fetch data from the database
            $result = mysqli_query($conn, $query);

            // Check if there are any records
            if (mysqli_num_rows($result) > 0) {
                echo "<table class='table table-bordered'>";
                echo "<thead class='thead-dark'><tr>";

                // Display table headers
                while ($fieldInfo = mysqli_fetch_field($result)) {
                    echo "<th>{$fieldInfo->name}</th>";
                }

                echo "</tr></thead><tbody>";

                // Display table data
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "No records found.";
            }
        }

        // Display Customers table
        $customersQuery = "SELECT * FROM customers";
        displayTable("Customers", $customersQuery, $conn);

        // Display Bookstores table
        $bookstoresQuery = "SELECT * FROM bookstores";
        displayTable("Bookstores", $bookstoresQuery, $conn);

        // Display Books table
        $booksQuery = "SELECT * FROM books";
        displayTable("Books", $booksQuery, $conn);

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
