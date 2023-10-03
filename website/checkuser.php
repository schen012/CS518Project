<?php

// Include database information and user information

require 'authentication.php';



// Check if the user is logged in

session_start();

if (!isset($_SESSION['db_is_logged_in']) || $_SESSION['db_is_logged_in'] !== true) {

    header("Location: login.php");

    exit();

}



// Connect to the database (make sure these variables are defined in authentication.php)

$conn = new mysqli($server, $sqlUsername, $sqlPassword, $databaseName);



// Check if the database connection was successful

if ($conn->connect_error) {

    die("Database connection failed: " . $conn->connect_error);

}



// Query the userprofile table to retrieve all registered users

$sql = "SELECT * FROM userprofile";

$query_result = $conn->query($sql);



if (!$query_result) {

    die("SQL Query ERROR: " . $conn->error);

}

?>



<!DOCTYPE html>

<html>

<head>

    <title>Check Users</title>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>

<body>

    <h2>Registered Users</h2>

    <table border="1">

        <tr>

            <th>User ID</th>

            <th>First Name</th>

            <th>Last Name</th>

            <th>Email</th>

        </tr>

        <?php

        // Fetch and display user data

        while ($row = $query_result->fetch_assoc()) {

            echo "<tr>";

            echo "<td>" . $row['userid'] . "</td>";

            echo "<td>" . $row['firstname'] . "</td>";

            echo "<td>" . $row['lastname'] . "</td>";

            echo "<td>" . $row['email'] . "</td>";

            echo "</tr>";

        }

        ?>

    </table>

    <br>

    <a href="main.php">Back to Main</a>

</body>

</html>

