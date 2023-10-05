<?php include 'session.php'; ?>


<?php


$userEmail = '';
if (!isset($_SESSION['user'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// echo "Email is " . $userEmail;

// Check if the logged-in user is an admin

$servername = "localhost"; // Your MySQL server host (usually 'localhost')
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password (leave empty if none)
$database = "authentication"; // Your database name
$table = "booked_cars_db"; // Your table name for rented cars

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the rented_cars_db table
$sql = "SELECT * FROM $table WHERE customer_email = '$email'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Car Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="mx-auto p-2 mt-5" style="width: 70vw;">
        <!-- Booked Cars Database -->
        <h1 class="text-center py-4">My Booking History</h1>
        <table class="table table-success">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Car model</th>
                    <th scope="col">Car number</th>
                    <th scope="col">Booked From</th>
                    <th scope="col">Booked Till</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Credit Status</th>
                    <th scope="col">Booking Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $s_no = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<th scope="row">' . $s_no  . '</th>';
                        echo '<td>' . $row['car_model'] . '</td>';
                        echo '<td>' . $row['car_number'] . '</td>';
                        echo '<td>' . $row['booked_from'] . '</td>';
                        echo '<td>' . $row['booked_till'] . '</td>';
                        echo '<td>' . "Rs." . $row['amount'] . '</td>';
                        $booked_status = $row['credit_status'];
                        $status = "Unpaid";
                        if ($booked_status == 1) {
                            $status = "Paid";
                        }
                        $s_no += 1;
                        echo '<td>' . $status   . '</td>';
                        echo '<td>' . $row['booking_date']   . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="text-center">
        <a href="/practise/index.php" class="fs-3 text-decoration-underline text-black ">Trying to book new car?</a>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>