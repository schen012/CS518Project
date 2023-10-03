<?php
session_start();
if (!isset($_SESSION['db_is_logged_in']) || $_SESSION['db_is_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
include('authentication.php');
$userid = $_SESSION['userID'];
// Query the "employee" table to fetch user data
$sql = "SELECT * FROM employee WHERE userid = '$userid'";
$query_result = $conn->query($sql);
if (!$query_result) {
    die("SQL Query ERROR. Unable to fetch user data.");
}
$userData = $query_result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Main Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
    <h2>Welcome, <?php echo $userData['firstname'] . ' ' . $userData['lastname']; ?></h2>
<a href="view_users.php">View Users</a>
<a href="approve.php">Approve Users</a>
    <a href="logout.php">Logout</a>

</body>

</html>

