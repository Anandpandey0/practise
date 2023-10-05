<?php include 'session.php'; ?>


<?php

if (!isset($_SESSION['user'])) {
  // User is not logged in, redirect to login page

  header("Location: admin_login.php");
  exit();
}

// Check if the logged-in user is an admin
if (!isUserAdmin(($role))) {
  // User is not an admin, redirect to a permission-denied page or display an error message
  // echo "You do not have permission to access this page.";
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
$sql = "SELECT * FROM $table";
$result = $conn->query($sql);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $model = $_POST["model"];
  $number = $_POST["number"];
  $capacity = $_POST["capacity"];
  $rent = $_POST["rent"];

  // Check if the number already exists in the database
  $checkSql = "SELECT * FROM $table WHERE number = '$number'";
  $checkResult = $conn->query($checkSql);

  if ($checkResult->num_rows > 0) {
    // The number already exists, show an alert message
    echo "<script>alert('Car with this number already exists.');</script>";
  } else {
    // The number doesn't exist, proceed with the insertion
    $sql = "INSERT INTO $table (model, number, capacity, rent) VALUES ('$model', '$number', '$capacity', $rent)";

    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Car added successfully!');</script>";
      header("Location: cars_db.php");
    } else {
      echo "<script>alert('Some error occurred');</script>";
    }
  }
}



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
    <!--  Cars Database -->
    <h1 class="text-center py-4"> Vehicle Database</h1>
    <table class="table table-success">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Vehicle model</th>
          <th scope="col">Vehicle number</th>
          <th scope="col">Capacity</th>
          <th scope="col">Rent per day</th>
          <th scope="col">Options</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          $s_no = 1;
          while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<th scope="row">' . $s_no . '</th>';
            echo '<td>' . $row['model'] . '</td>';
            echo '<td>' . $row['number'] . '</td>';
            echo '<td>' . $row['capacity'] . '</td>';
            echo '<td>' . "Rs." . $row['rent'] . '</td>';
            echo '<td>
                    <a href="update_car.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a>
                    <a href="delete_car.php?id=' . $row['id'] . '" class="btn btn-danger">Delete</a>
                  </td>';
            echo '</tr>';
            $s_no += 1;
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <!-- Button trigger modal -->
  <div class="mx-auto p-2 mt-5 d-flex" style="width: 70vw;">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Add Car
    </button>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add a car</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class=" mb-3">
              <label for="exampleInputModel" class="form-label">Vehicle Model</label>
              <input type="text" class="form-control" id="exampleInputModel" name="model" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
              <label for="exampleInputNumber" class="form-label">Vehicle Number</label>
              <input type="text" class="form-control" name="number" id="exampleInputNumber" required>
            </div>
            <div class="mb-3">
              <label for="exampleInputSeatingCapacity" class="form-label">Seating Capacity</label>
              <input type="text" class="form-control" name="capacity" id="exampleInputSeatingCapacity" required>
            </div>
            <div class="mb-3">
              <label for="exampleInputPerDayRent" class="form-label">Per Day Rent</label>
              <input type="text" class="form-control" name="rent" id="exampleInputPerDayRent" required>
            </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="text-center ">
    <a href="/practise/admin_portal.php">Refer to Booked DB</a>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>