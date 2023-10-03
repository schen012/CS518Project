<?php
// Include database information and user information
require 'authentication.php';
// Connect to the database (make sure these variables are defined in authentication.php)
$conn = new mysqli($server, $sqlUsername, $sqlPassword, $databaseName);
// Check if the database connection was successful
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
// Query to retrieve user data from the 'users' table
$sql = "SELECT username, firstname, lastname, email, is_approved FROM users";
$query_result = $conn->query($sql);
if (!$query_result) {
    die("SQL Query ERROR: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <meta charset="utf-8">
</head>
<body>
    <h2>User List</h2>
    <table width="600" border="1" align="center" cellpadding="2" cellspacing="2">
        <tr>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Approval Status</th>
        </tr>
        <?php
        // Display a list of users and their approval status
        while ($row = $query_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['firstname']}</td>";
            echo "<td>{$row['lastname']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['is_approved']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
