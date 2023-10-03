<?php
// Include database information and user information
require 'authentication.php';
// Connect to the database (make sure these variables are defined in authentication.php)
$conn = new mysqli($server, $sqlUsername, $sqlPassword, $databaseName);
// Check if the database connection was successful
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
// Get the ID of the user to be approved from the URL
if (isset($_GET['username'])) {
    $username = $_GET['username'];
    // Retrieve the user registration request
    $sql = "SELECT * FROM user_registration_requests WHERE username = '$username'";
    $query_result = $conn->query($sql);
    if (!$query_result) {
        die("SQL Query ERROR: " . $conn->error);
    }
    // Fetch the user registration data
    $userRegistrationData = $query_result->fetch_assoc();
    // Extract the relevant data
    $username = $userRegistrationData['username'];
    $password = $userRegistrationData['password'];
    $firstname = $userRegistrationData['firstname'];
    $lastname = $userRegistrationData['lastname'];
    $email = $userRegistrationData['email'];
    // Insert the approved user into the 'users' table
    $sqlInsert = "INSERT INTO users (username, password, firstname, lastname, email, is_approved) 
                  VALUES ('$username', '$password', '$firstname', '$lastname', '$email', 1)";
    $query_result_insert = $conn->query($sqlInsert);
    if (!$query_result_insert) {
        die("SQL Insert Query ERROR: " . $conn->error);
    }
    // Delete the user registration request from the 'user_registration_requests' table
    $sqlDelete = "DELETE FROM user_registration_requests WHERE username = '$username'";
    $query_result_delete = $conn->query($sqlDelete);
    if (!$query_result_delete) {
        die("SQL Delete Query ERROR: " . $conn->error);
    }
    // Redirect back to the admin approval page
    header('Location: approve.php');
    exit;
} else {
    die("Invalid request.");
}
?>
