<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit;
}
?>
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
    <a class="navbar-brand" href="">Creative Learning</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

    // Function to display a table with search
    function displayTableWithSearch($title, $query, $conn)
    {
        echo "<div class='accordion' id='{$title}Accordion'>";
        echo "<div class='card'>";
        echo "<div class='card-header' id='{$title}Heading'>";
        echo "<h2 class='mb-0'>";
        echo "<button class='btn btn-link' type='button' data-toggle='collapse' data-target='#{$title}Collapse'
                aria-expanded='true' aria-controls='{$title}Collapse'>
                $title
            </button>";
        echo "</h2>";
        echo "</div>";

        echo "<div id='{$title}Collapse' class='collapse show' aria-labelledby='{$title}Heading'
              data-parent='#{$title}Accordion'>";
        echo "<div class='card-body'>";

        // Display search form
        echo "<form action='' method='post' class='mb-3'>
            <div class='input-group'>
                <input type='text' class='form-control' placeholder='Search' name='search_term' aria-label='Search' aria-describedby='searchButton'>
                <div class='input-group-append'>
                    <button class='btn btn-outline-secondary' type='submit' id='searchButton'>Search</button>
                </div>
            </div>
        </form>";

        // Check if the search form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchTerm = mysqli_real_escape_string($conn, $_POST['search_term']);
            $query .= " WHERE CONCAT(" . implode(", ", getTableColumns($conn, $query)) . ") LIKE '%$searchTerm%'";
        }

        // Fetch data from the database
        $result = mysqli_query($conn, $query);

        // Check if there are any records
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-responsive'>";
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
            echo "</div>"; // table-responsive
        } else {
            echo "No records found.";
        }

        echo "</div>"; // card-body
        echo "</div>"; // collapse
        echo "</div>"; // card
        echo "</div>"; // accordion
    }

    // Function to get column names of a table
    function getTableColumns($conn, $query)
    {
        $result = mysqli_query($conn, $query . " LIMIT 1");
        $columns = [];

        while ($fieldInfo = mysqli_fetch_field($result)) {
            $columns[] = $fieldInfo->name;
        }

        return $columns;
    }

    // Display Customers table with search
    $customersQuery = "SELECT * FROM customers";
    displayTableWithSearch("Customers", $customersQuery, $conn);

    // Display Bookstores table with search
    $bookstoresQuery = "SELECT * FROM bookstores";
    displayTableWithSearch("Bookstores", $bookstoresQuery, $conn);

    // Display Books table with search
    $booksQuery = "SELECT * FROM books";
    displayTableWithSearch("Books", $booksQuery, $conn);

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
