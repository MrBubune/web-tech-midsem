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

// Check if the form is submitted (for each section)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_customer'])) {
        // Retrieve form data for creating customers
        $customer_name = $_POST['customer_name'];
        $customer_id = $_POST['customer_id'];

        // Insert data into the customers table
        $insertQuery = "INSERT INTO customers (customer_id, customer_name) VALUES ('$customer_id', '$customer_name')";
        $result = mysqli_query($conn, $insertQuery);

        if ($result) {
            $customer_message = 'Customer successfully added.';
        } else {
            $customer_error = 'Error adding customer: ' . mysqli_error($conn);
        }
    } elseif (isset($_POST['create_bookstore'])) {
        // Retrieve form data for creating bookstores
        $bookstore_name = $_POST['bookstore_name'];
        $bookstore_id = $_POST['bookstore_id'];
        $bookstore_city = $_POST['bookstore_city'];
        $bookstore_state = $_POST['bookstore_state'];

        // Insert data into the bookstores table
        $insertQuery = "INSERT INTO bookstores (bookstore_id, bookstore_name, city, state) VALUES ('$bookstore_id', '$bookstore_name', '$bookstore_city', '$bookstore_state')";
        $result = mysqli_query($conn, $insertQuery);

        if ($result) {
            $bookstore_message = 'Bookstore successfully added.';
        } else {
            $bookstore_error = 'Error adding bookstore: ' . mysqli_error($conn);
        }
    } elseif (isset($_POST['create_book'])) {
        // Retrieve form data for creating books
        $book_title = $_POST['book_title'];
        $isbn = $_POST['isbn'];
        $author = $_POST['author'];

        // Insert data into the books table
        $insertQuery = "INSERT INTO books (isbn, book_name, author) VALUES ('$isbn', '$book_title', '$author')";
        $result = mysqli_query($conn, $insertQuery);

        if ($result) {
            $book_message = 'Book successfully added.';
        } else {
            $book_error = 'Error adding book: ' . mysqli_error($conn);
        }
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
    <title>Create Entities</title>
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

        <div class="accordion" id="createEntitiesAccordion">

            <!-- Create Customer Section -->
            <div class="card">
                <div class="card-header" id="createCustomerHeading">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#createCustomerCollapse" aria-expanded="true" aria-controls="createCustomerCollapse">
                            Create Customer
                        </button>
                    </h2>
                </div>

                <div id="createCustomerCollapse" class="collapse" aria-labelledby="createCustomerHeading" data-parent="#createEntitiesAccordion">
                    <div class="card-body">
                        <?php if (isset($customer_message)) : ?>
                            <div class="alert alert-success" role="alert"><?php echo $customer_message; ?></div>
                        <?php endif; ?>

                        <?php if (isset($customer_error)) : ?>
                            <div class="alert alert-danger" role="alert"><?php echo $customer_error; ?></div>
                        <?php endif; ?>

                        <form action="" method="post">
                            <div class="form-group">
                                <label for="customer_id">Customer ID:</label>
                                <input type="text" id="customer_id" name="customer_id" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="customer_name">Customer Name:</label>
                                <input type="text" id="customer_name" name="customer_name" class="form-control" required>
                            </div>

                            <button type="submit" name="create_customer" class="btn btn-primary">Create Customer</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Create Bookstore Section -->
            <div class="card">
                <div class="card-header" id="createBookstoreHeading">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#createBookstoreCollapse" aria-expanded="false" aria-controls="createBookstoreCollapse">
                            Create Bookstore
                        </button>
                    </h2>
                </div>

                <div id="createBookstoreCollapse" class="collapse" aria-labelledby="createBookstoreHeading" data-parent="#createEntitiesAccordion">
                    <div class="card-body">
                        <?php if (isset($bookstore_message)) : ?>
                            <div class="alert alert-success" role="alert"><?php echo $bookstore_message; ?></div>
                        <?php endif; ?>

                        <?php if (isset($bookstore_error)) : ?>
                            <div class="alert alert-danger" role="alert"><?php echo $bookstore_error; ?></div>
                        <?php endif; ?>

                        <form action="" method="post">
                            <div class="form-group">
                                <label for="bookstore_id">Bookstore ID:</label>
                                <input type="text" id="bookstore_id" name="bookstore_id" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="bookstore_name">Bookstore Name:</label>
                                <input type="text" id="bookstore_name" name="bookstore_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="bookstore_city">Bookstore City:</label>
                                <input type="text" id="bookstore_city" name="bookstore_city" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="bookstore_state">Bookstore State:</label>
                                <input type="text" id="bookstore_state" name="bookstore_state" class="form-control" required>
                            </div>

                            <button type="submit" name="create_bookstore" class="btn btn-primary">Create Bookstore</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Create Book Section -->
            <div class="card">
                <div class="card-header" id="createBookHeading">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#createBookCollapse" aria-expanded="false" aria-controls="createBookCollapse">
                            Create Book
                        </button>
                    </h2>
                </div>

                <div id="createBookCollapse" class="collapse" aria-labelledby="createBookHeading" data-parent="#createEntitiesAccordion">
                    <div class="card-body">
                        <?php if (isset($book_message)) : ?>
                            <div class="alert alert-success" role="alert"><?php echo $book_message; ?></div>
                        <?php endif; ?>

                        <?php if (isset($book_error)) : ?>
                            <div class="alert alert-danger" role="alert"><?php echo $book_error; ?></div>
                        <?php endif; ?>

                        <form action="" method="post">
                            <div class="form-group">
                                <label for="isbn">ISBN:</label>
                                <input type="text" id="isbn" name="isbn" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="book_title">Book Title:</label>
                                <input type="text" id="book_title" name="book_title" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="author">Author:</label>
                                <input type="text" id="author" name="author" class="form-control" required>
                            </div>

                            <button type="submit" name="create_book" class="btn btn-primary">Create Book</button>
                        </form>
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
