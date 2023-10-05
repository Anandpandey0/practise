<?php
$id = $_GET['id'];
session_start();

echo $id;
function isUserAdmin($role)
{
    return $role === "admin";
}
if (!isset($_SESSION['user'])) {
    // User is not logged in, redirect to login page
    header("Location: admin_login.php");
    exit();
}

// Check if the logged-in user is an admin
if (!isUserAdmin($_SESSION['user']['role'])) {
    // User is not an admin, redirect to a permission-denied page or display an error message
    header("Location: error.php");
    exit();
}
$servername = "localhost"; // Your MySQL server host (usually 'localhost')
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password (leave empty if none)
$database = "authentication"; // Your database name
$table = "cars_db_admin"; // Your table name for rented cars

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the rented_cars_db table
$sql = "DELETE FROM `cars_db_admin` WHERE `cars_db_admin`.`id` = $id";
$result = $conn->query($sql);
if ($conn->query($sql) === TRUE) {
    // echo "<script>alert('$rent');</script>";
    header("Location: cars_db.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
