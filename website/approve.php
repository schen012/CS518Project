<?php

// Include database information and user information
require 'authentication.php';
session_start();
// Connect to the database (make sure these variables are defined in authentication.php)
$conn = new mysqli($server, $sqlUsername, $sqlPassword, $databaseName);
// Check if the database connection was successful
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
// Get a list of pending user registration requests
$sql = "SELECT * FROM user_registration_requests";
$query_result = $conn->query($sql);
if (!$query_result) {
    die("SQL Query ERROR: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Approval</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
    <h2>Pending User Registration Requests</h2>
    <table width="600" border="1" align="center" cellpadding="2" cellspacing="2">
        <tr>
            <th>User Name</th>
	    <th>Password</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php
        // Display a list of pending registration requests
        while ($row = $query_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['password']}</td>";
            echo "<td>{$row['firstname']}</td>";
            echo "<td>{$row['lastname']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td><a href='approve_user.php?username={$row['username']}'>Approve</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
<p><a href="main.php">Back to Main Page</a></p>
</body>
</html>

