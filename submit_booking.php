<?php
session_start();


if (isset($_POST['amountToBePaid'])) {
    $amount = $_POST['amountToBePaid'];

    // echo "Received variable from JavaScript: " . $receivedVariable;
}
if (isset($_POST['update'])) {
    $customer_name = $_SESSION['user']['name']; // Assuming you want to use the logged-in user's username as the customer name
    $customer_email = $_SESSION['user']['email'];   // Assuming you want to use the logged-in user's email as the customer email
    $car_model = $_POST['model'];
    $car_number = $_POST['number'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $totalAmount = $amount;

    // Your database connection code here
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "authentication";
    $table = "booked_cars_db";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the booking details into the "booked_cars_db" table
    $insertSql = "INSERT INTO $table ( customer_name, customer_email, car_model, car_number, booked_from, booked_till, amount  )
                  VALUES ('$customer_name', '$customer_email', '$car_model', '$car_number', '$from', '$to', '$totalAmount')";

    if ($conn->query($insertSql) === TRUE) {
        echo "Booking successful!";
        header("Location: my_booking.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
