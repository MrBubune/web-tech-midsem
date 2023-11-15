<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About/Help</title>
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
        <div class="about-help">
            <h2>About/Help</h2>

            <section>
                <h4>System Overview</h4>
                <p>
                    Welcome to the Sales Management System. This system is designed to streamline the sales process
                    for multiple bookstores connected to a central server. It facilitates the recording of sales
                    transactions,
                    analysis of sales data, and decision-making based on the performance of individual bookstores.
                </p>
            </section>

            <section>
                <h4>How to Use</h4>
                <p>
                    To get started, use the navigation menu to access different functionalities of the system:
                    Sales Entry, Server Upload, Main Server Dashboard, Decision-Making Page, Record Keeping, User
                    Management, Settings,
                    and this About/Help page. Each section serves a specific purpose in managing and analyzing sales
                    data.
                </p>
            </section>

            <section>
                <h4>Help Documentation</h4>
                <p>
                    For detailed instructions and FAQs, please refer to the <a
                        href="https://github.com/MrBubune/web-tech-midsem#readme"> help documentation </a> provided with
                    the system.
                    If you encounter any issues or have specific questions, feel free to reach out to our support team.
                </p>
            </section>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>