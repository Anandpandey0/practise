<?php
$servername = "localhost"; // Your MySQL server host (usually 'localhost')
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password (leave empty if none)
$database = "authentication"; // Your database name
$table = "users_db"; // Your table name

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $rePassword = $_POST["re_password"]; // Add this line

  // Check if passwords match
  if ($password != $rePassword) {
    echo "<script>alert('Password Mismatch!');</script>";
  } else {
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert data into the table
    $sql = "INSERT INTO $table (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Registration successful!');</script>";
      session_start();
      $_SESSION['user'] = array(
        'user_id' => $userId,
        'name' => $name,
        'email' => $email,
        'role' => $role,
      );
      header("Location: index.php");
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                  <form class="mx-1 mx-md-4" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateForm()">

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="text" id="namefield" class="form-control" name="name" />
                        <label class="form-label" for="namefield">Your Name</label>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="email" id="emailfield" class="form-control" name="email" />
                        <label class="form-label" for="emailfield">Your Email</label>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="password" id="passwordfield" class="form-control" name="password" />
                        <label class="form-label" for="passwordfield">Password</label>
                      </div>
                    </div>
                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="password" id="repasswordfield" class="form-control" name="re_password" />
                        <label class="form-label" for="repasswordfield">Re Enter Password</label>
                      </div>
                    </div>

                    <div class="form-check d-flex justify-content-center mb-5">
                      <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                      <label class="form-check-label" for="form2Example3">
                        I agree all statements in <a href="#!">Terms of service</a>
                      </label>
                    </div>

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <button type="submit" class="btn btn-primary btn-lg">Register</button>
                    </div>

                  </form>

                </div>
                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                  <img src="./register.webp" class="img-fluid" alt="Sample image">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script>
    function validateForm() {
      // Get the values entered by the user
      var name = document.getElementById("namefield").value;
      var email = document.getElementById("emailfield").value;
      var password = document.getElementById("passwordfield").value;
      var rePassword = document.getElementById("repasswordfield").value;

      // Validate password
      var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/;
      if (!passwordPattern.test(password)) {
        alert("Password must be at least 8 characters and include at least one capital letter, one small letter, one special character, and one number.");
        return false;
      }

      // Validate email
      var emailPattern = /^[A-Za-z0-9._%-]+@(gmail\.com|outlook\.com|yahoo\.com)$/;
      if (!emailPattern.test(email)) {
        alert("Email must be from a valid domain like gmail.com, outlook.com, or yahoo.com.");
        return false;
      }

      // Check if password and re-entered password match
      if (password !== rePassword) {
        alert("Passwords do not match.");
        return false;
      }

      // All validation checks passed, allow form submission
      return true;
    }
  </script>




</body>

</html>