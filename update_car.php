<?php
session_start();

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
    echo "You do not have permission to access this page.";
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"]; // Ensure you get the 'id' from the form

    $new_model = $_POST["model"];
    $new_number = $_POST["number"];
    $new_capacity = $_POST["capacity"];
    $new_rent = $_POST["rent"];

    // SQL query to update data in the table
    $sql = "UPDATE $table SET model = '$new_model', number = '$new_number', capacity = '$new_capacity', rent = '$new_rent' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: cars_db.php");
        exit(); // Ensure you exit after the redirect
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch data from the rented_cars_db table based on the provided 'id'
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM $table WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $model = $row["model"];
        $number = $row["number"];
        $capacity = $row["capacity"];
        $rent = $row["rent"];
    } else {
        echo "Car not found.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Car Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body style="background-color: antiquewhite">
    <h1 class="text-center mt-4 text-decoration-underline">Update Car Details</h1>
    <div style="width: 40vw; border: solid 2px black; margin-top: 5rem; padding: 2.5rem; background-color: white; border-radius: 25px" class="mx-auto">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Add a hidden field to submit 'id' -->

            <div class=" mb-3">
                <label for="exampleInputModel" class="form-label">Vehicle Model</label>
                <input type="text" class="form-control" id="exampleInputModel" name="model" aria-describedby="emailHelp" value="<?php echo $model; ?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputNumber" class="form-label">Vehicle Number</label>
                <input type="text" class="form-control" name="number" id="exampleInputNumber" value="<?php echo $number; ?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputSeatingCapacity" class="form-label">Seating Capacity</label>
                <input type="text" class="form-control" name="capacity" id="exampleInputSeatingCapacity" value="<?php echo $capacity; ?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputPerDayRent" class="form-label">Per Day Rent</label>
                <input type="text" class="form-control" name="rent" id="exampleInputPerDayRent" value="<?php echo $rent; ?>">
            </div>

            <div class="modal-footer ">
                <a class="btn btn-secondary mx-4" href="/practise/cars_db.php">Back</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>