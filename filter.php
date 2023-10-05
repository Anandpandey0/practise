<?php
// Initialize $filterValue from GET parameter if it's present, or set it to 0
$filterValue = isset($_GET['capacity']) ? $_GET['capacity'] : 0;

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if filterValue has been set in the POST data
    if (isset($_POST["filterValue"])) {
        $filterValue = $_POST["filterValue"];
        if ($filterValue == 0) {
            header("Location: index.php");
            exit();
        }

        // Construct the URL based on the selected filterValue
        $redirectUrl = "index.php?capacity=" . $filterValue;

        // Redirect to the constructed URL
        header("Location: " . $redirectUrl);
        exit(); // Terminate script to ensure the redirection takes place
    } else {
        // Handle the case where filterValue is not set
        echo "filterValue is not set in the form submission.";
    }
}
?>

<div class="container mt-2" style="width: 20vw; float:left">
    <form id="myForm" method="post">
        <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="filterValue" onchange="submitForm()">
                <option <?php echo $filterValue == 0 ? 'selected' : ''; ?> value="0">No Filter</option>
                <option <?php echo $filterValue == 2 ? 'selected' : ''; ?> value="2">2 Seater</option>
                <option <?php echo $filterValue == 4 ? 'selected' : ''; ?> value="4">4 Seater</option>
                <option <?php echo $filterValue == 6 ? 'selected' : ''; ?> value="6">6 Seater</option>
            </select>
        </div>
    </form>
</div>

<script>
    function submitForm() {
        document.getElementById("myForm").submit();
    }
</script>