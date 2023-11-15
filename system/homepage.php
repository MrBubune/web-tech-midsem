<?php
session_start();
// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit;
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Management System</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

        <!-- Bootstrap Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="">Creative Learning</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
        <h1>Welcome to the Creative Learning Sales Management System</h1>
        <p>Creative Learning is a group of publishers located at New York. Recently, the organization has moved into retailing the books published at the publishing house. To start with, the organization has established bookstores at six locations in New York. However, the organization aims at increasing the number of bookstores in the forthcoming years. In addition, the organization is looking forward to establishing bookstores across all major states in the United States.</p>


    <!-- Add Bootstrap JS and Popper.js scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
