<?php
session_start();

// Initialize user-related variables
$userId = '';
$name = '';
$email = '';
$role = '';

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    $userInfo = $_SESSION['user'];
    $userId = $userInfo['user_id'];
    $name = $userInfo['name'];
    $email = $userInfo['email'];
    $role = $userInfo['role'];
}



if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php"); // Redirect to the dashboard or profile page
    exit();
}
function isUserAdmin($role)
{
    return $role === "admin";
}


// Close the database connection
