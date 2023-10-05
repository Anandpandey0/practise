<?php
$id = $_GET['id'];
session_start();

// echo $id;
function isUserAdmin($role)
{
    return $role === "admin";
}
if (!isset($_SESSION['user'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
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
mysqli_set_charset($conn, "utf8");

// Fetch data from the rented_cars_db table
$sql = "SELECT * FROM $table WHERE `$table`.`id` = $id";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $model = htmlspecialchars($row["model"]);
    // echo $model;
    // var_dump($model);
    $number = htmlspecialchars($row["number"]);
    $capacity = $row["capacity"];
    $rent = $row["rent"];
    $id = $row['id'];


    // echo $model;
}
if (isset($_POST['amountToBePaid'])) {
    $amount = $_POST['amount'];

    // echo "Received variable from JavaScript: " . $receivedVariable;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body style="background-color:antiquewhite">
    <h1 class="text-center mt-4 text-decoration-underline">Book your ride</h1>
    <div style="width: 40vw; border: solid 2px black; margin-top:5rem;padding:2.5rem; background-color:white; border-radius:25px" class="mx-auto">


        <form method="post" action="submit_booking.php">
            <div class=" mb-3">
                <label for="exampleInputModel" class="form-label">Vehicle Model</label>
                <input type="text" class="form-control fw-bold" id="exampleInputModel" name="model" aria-describedby="emailHelp" value="<?php echo htmlspecialchars($model); ?>" readonly>
            </div>
            <div class=" mb-3">
                <label for="exampleInputNumber" class="form-label">Vehicle Number</label>
                <input type="text" class="form-control fw-bold" id="exampleInputNumber" name="number" aria-describedby="emailHelp" value="<?php echo htmlspecialchars($number); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputCapacity" class="form-label">Vehicle capacity</label>
                <input type="text" class="form-control fw-bold" id="exampleInputCapacity" name="capacity" aria-describedby="emailHelp" value=<?php echo htmlspecialchars($capacity); ?> readonly>
            </div>
            <div class="mb-3">

                <label for="exampleInputRent" class="form-label">Rent per day</label>
                <input type="text" class="form-control fw-bold" id="exampleInputRent" name="rent" aria-describedby="emailHelp" value=<?php echo "Rs." . $rent; ?> readonly>

            </div>
            <div class="mb-3">
                <label for="datetime form-label">From:</label>
                <input type="date" id="from" class="form-control" name="from" min="" required>
            </div>
            <div class="mb-3">
                <label for="datetime form-label">To:</label>
                <input type="date" id="to" class="form-control" name="to" min="" required>
            </div>
            <div class="mb-3">
                <p for="exampleInputModel" class="form-label">Amount to be paid</p>
                <p class="form-control fw-bold" name="totalAmount" aria-describedby="emailHelp" id="totalAmount">0.00</p>
                <input type="hidden" id="amountToBePaid" name="amountToBePaid">

            </div>



            <div class="modal-footer ">
                <a class="btn btn-secondary mx-4" href="/practise/index.php">Back</a>
                <button type="submit" name="update" class="btn btn-primary">Book</button>
            </div>
        </form>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        const fromInput = document.getElementById("from");
        const toInput = document.getElementById("to");
        const now = new Date();
        const minDate = now.toISOString().slice(0, 16); // Format: YYYY-MM-DDTHH:MM
        fromInput.setAttribute("min", minDate);

        fromInput.addEventListener("change", () => {
            // When "from" date and time is selected, set "to" min value to be after "from"
            toInput.setAttribute("min", fromInput.value);
        });
        fromInput.addEventListener("input", calculateTotalAmount);
        toInput.addEventListener("input", calculateTotalAmount);
        const rentPerDay = <?php echo $rent; ?>;

        function calculateTotalAmount() {
            // Get the values of "from" and "to" inputs
            const fromValue = new Date(fromInput.value);
            const toValue = new Date(toInput.value);

            // Calculate the difference in days
            const differenceInMilliseconds = toValue - fromValue;
            const differenceInDays = differenceInMilliseconds / (1000 * 60 * 60 * 24);

            // Calculate the total amount using the rent per day from PHP
            const totalAmount = rentPerDay * differenceInDays;

            document.getElementById("amountToBePaid").value = totalAmount;
            // Display the total amount
            const totalAmountElement = document.getElementById("totalAmount");
            if (totalAmount) {
                totalAmountElement.textContent = "Rs:" + " " + `${totalAmount.toFixed(2)}`;
            }
        }
    </script>
</body>

</html>