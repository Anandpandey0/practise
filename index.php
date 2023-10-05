<?php include 'session.php'; ?>

<?php
// Check if the user is logged in
$role = '';
if (isset($_SESSION['user'])) {
    $userInfo = $_SESSION['user'];
    $userEmail = $userInfo['email'];
    $userName = $userInfo['name'];
    $role = $userInfo['role'];
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
}
$servername = "localhost"; // Your MySQL server host (usually 'localhost')
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password (leave empty if none)
$database = "authentication"; // Your database name
$table = "cars_db_admin";
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch car records from the database
$sql = "SELECT * FROM $table";
if (isset($_GET['capacity'])) {
    $capacity = $_GET['capacity'];
    // Add a WHERE clause to filter by capacity
    // echo $capacity;
    $sql .= " WHERE capacity = '$capacity'";
}
$result = $conn->query($sql);

// Initialize an empty array to store car records
$cars = array();

// Check if there are rows in the result set
if ($result->num_rows > 0) {
    // Fetch each row as an associative array and add it to the $cars array
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
}

// Close the database connection
$conn->close();



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <?php include 'navbar.php'; ?>
    <?php include 'filter.php'; ?>
    <div class="container text-center cars-container mt-4 pt-4">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($cars as $car) : ?>
                <div class="col">
                    <div class="card">
                        <img class="card-img-top" src="./car-image.avif" alt="Card image cap">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p class="card-text">Vehicle Model:</p>
                                <span class="fw-bolder"><?php echo $car['model']; ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text">Vehicle Number:</p>
                                <span class="fw-bolder"><?php echo $car['number']; ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text">Seating Capacity:</p>
                                <span class="fw-bolder"><?php echo $car['capacity']; ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text">Rent per day:</p>
                                <span class="fw-bolder"><?php echo "Rs." . " " . $car['rent']; ?></span>
                            </div>
                            <?php if ($role != 'admin') : ?>
                                <!-- Display "My Databases" for admin -->
                                <a href="<?php echo "book.php?id=" . $car['id'] ?>" class="btn btn-primary">Book</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>