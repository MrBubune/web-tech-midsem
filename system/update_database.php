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
        // Insert new customer
        $customer_name = $_POST['customer_name'];
        $customer_id = $_POST['customer_id'];

        $insertQuery = "INSERT INTO customers (customer_id, customer_name) VALUES ('$customer_id', '$customer_name')";
        $result = mysqli_query($conn, $insertQuery);

        if ($result) {
            $customer_message = 'Customer successfully added.';
        } else {
            $customer_error = 'Error adding customer: ' . mysqli_error($conn);
        }
    } elseif (isset($_POST['update_customer'])) {
        // Update existing customer
        $customer_name = $_POST['customer_name'];
        $customer_id = $_POST['customer_id'];

        $updateQuery = "UPDATE customers SET customer_name='$customer_name' WHERE customer_id='$customer_id'";
        $result = mysqli_query($conn, $updateQuery);

        if ($result) {
            $customer_message = 'Customer successfully updated.';
        } else {
            $customer_error = 'Error updating customer: ' . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_customer'])) {
        // Delete existing customer
        $customer_id = $_POST['customer_id'];

        $deleteQuery = "DELETE FROM customers WHERE customer_id='$customer_id'";
        $result = mysqli_query($conn, $deleteQuery);

        if ($result) {
            $customer_message = 'Customer successfully deleted.';
        } else {
            $customer_error = 'Error deleting customer: ' . mysqli_error($conn);
        }
    } elseif (isset($_POST['create_bookstore'])) {
        // Insert new bookstore
        $bookstore_name = $_POST['bookstore_name'];
        $bookstore_id = $_POST['bookstore_id'];
        $bookstore_city = $_POST['bookstore_city'];
        $bookstore_state = $_POST['bookstore_state'];

        $insertQuery = "INSERT INTO bookstores (bookstore_id, bookstore_name, city, state) VALUES ('$bookstore_id', '$bookstore_name', '$bookstore_city', '$bookstore_state')";
        $result = mysqli_query($conn, $insertQuery);

        if ($result) {
            $bookstore_message = 'Bookstore successfully added.';
        } else {
            $bookstore_error = 'Error adding bookstore: ' . mysqli_error($conn);
        }
    } elseif (isset($_POST['update_bookstore'])) {
        // Update existing bookstore
        $bookstore_name = $_POST['bookstore_name'];
        $bookstore_id = $_POST['bookstore_id'];
        $bookstore_city = $_POST['bookstore_city'];
        $bookstore_state = $_POST['bookstore_state'];

        $updateQuery = "UPDATE bookstores SET bookstore_name='$bookstore_name', city='$bookstore_city', state='$bookstore_state' WHERE bookstore_id='$bookstore_id'";
        $result = mysqli_query($conn, $updateQuery);

        if ($result) {
            $bookstore_message = 'Bookstore successfully updated.';
        } else {
            $bookstore_error = 'Error updating bookstore: ' . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_bookstore'])) {
        // Delete existing bookstore
        $bookstore_id = $_POST['bookstore_id'];

        $deleteQuery = "DELETE FROM bookstores WHERE bookstore_id='$bookstore_id'";
        $result = mysqli_query($conn, $deleteQuery);

        if ($result) {
            $bookstore_message = 'Bookstore successfully deleted.';
        } else {
            $bookstore_error = 'Error deleting bookstore: ' . mysqli_error($conn);
        }
    } elseif (isset($_POST['create_book'])) {
        // Insert new book
        $book_title = $_POST['book_title'];
        $isbn = $_POST['isbn'];
        $author = $_POST['author'];

        $insertQuery = "INSERT INTO books (isbn, book_name, author) VALUES ('$isbn', '$book_title', '$author')";
        $result = mysqli_query($conn, $insertQuery);

        if ($result) {
            $book_message = 'Book successfully added.';
        } else {
            $book_error = 'Error adding book: ' . mysqli_error($conn);
        }
    } elseif (isset($_POST['update_book'])) {
        // Update existing book
        $book_title = $_POST['book_title'];
        $isbn = $_POST['isbn'];
        $author = $_POST['author'];

        $updateQuery = "UPDATE books SET book_name='$book_title', author='$author' WHERE isbn='$isbn'";
        $result = mysqli_query($conn, $updateQuery);

        if ($result) {
            $book_message = 'Book successfully updated.';
        } else {
            $book_error = 'Error updating book: ' . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_book'])) {
        // Delete existing book
        $isbn = $_POST['isbn'];

        $deleteQuery = "DELETE FROM books WHERE isbn='$isbn'";
        $result = mysqli_query($conn, $deleteQuery);

        if ($result) {
            $book_message = 'Book successfully deleted.';
        } else {
            $book_error = 'Error deleting book: ' . mysqli_error($conn);
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
    <title>Create, Update, and Delete Entities</title>
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

        <div class="accordion" id="crudEntitiesAccordion">

            <!-- Create Customer Section -->
            <div class="card">
                <div class="card-header" id="customerCrudHeading">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#customerCrudCollapse" aria-expanded="true" aria-controls="customerCrudCollapse">
                            Customer CRUD
                        </button>
                    </h2>
                </div>

                <div id="customerCrudCollapse" class="collapse" aria-labelledby="customerCrudHeading" data-parent="#crudEntitiesAccordion">
                    <div class="card-body">
                        <?php if (isset($customer_message)) : ?>
                            <div class="alert alert-success" role="alert"><?php echo $customer_message; ?></div>
                        <?php endif; ?>

                        <?php if (isset($customer_error)) : ?>
                            <div class="alert alert-danger" role="alert"><?php echo $customer_error; ?></div>
                        <?php endif; ?>

                        <!-- Create Customer Form -->
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
                            <button type="submit" name="update_customer" class="btn btn-warning">Update Customer</button>
                            <button type="submit" name="delete_customer" class="btn btn-danger">Delete Customer</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Create Bookstore Section -->
            <div class="card">
                <div class="card-header" id="bookstoreCrudHeading">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#bookstoreCrudCollapse" aria-expanded="true" aria-controls="bookstoreCrudCollapse">
                            Bookstore CRUD
                        </button>
                    </h2>
                </div>

                <div id="bookstoreCrudCollapse" class="collapse" aria-labelledby="bookstoreCrudHeading" data-parent="#crudEntitiesAccordion">
                    <div class="card-body">
                        <?php if (isset($bookstore_message)) : ?>
                            <div class="alert alert-success" role="alert"><?php echo $bookstore_message; ?></div>
                        <?php endif; ?>

                        <?php if (isset($bookstore_error)) : ?>
                            <div class="alert alert-danger" role="alert"><?php echo $bookstore_error; ?></div>
                        <?php endif; ?>

                        <!-- Create Bookstore Form -->
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
                            <button type="submit" name="update_bookstore" class="btn btn-warning">Update Bookstore</button>
                            <button type="submit" name="delete_bookstore" class="btn btn-danger">Delete Bookstore</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Create Book Section -->
            <div class="card">
                <div class="card-header" id="bookCrudHeading">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#bookCrudCollapse" aria-expanded="true" aria-controls="bookCrudCollapse">
                            Book CRUD
                        </button>
                    </h2>
                </div>

                <div id="bookCrudCollapse" class="collapse" aria-labelledby="bookCrudHeading" data-parent="#crudEntitiesAccordion">
                    <div class="card-body">
                        <?php if (isset($book_message)) : ?>
                            <div class="alert alert-success" role="alert"><?php echo $book_message; ?></div>
                        <?php endif; ?>

                        <?php if (isset($book_error)) : ?>
                            <div class="alert alert-danger" role="alert"><?php echo $book_error; ?></div>
                        <?php endif; ?>

                        <!-- Create Book Form -->
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
                            <button type="submit" name="update_book" class="btn btn-warning">Update Book</button>
                            <button type="submit" name="delete_book" class="btn btn-danger">Delete Book</button>
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
