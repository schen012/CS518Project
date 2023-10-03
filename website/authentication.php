<?php

$server = "localhost";

$sqlUsername = "schen";

$sqlPassword = "Chen67578988";

$databaseName = "mynewdb"; // Change the database name to "mynewdb"



$conn = new mysqli($server, $sqlUsername, $sqlPassword, $databaseName);



function authenticateUser($connection, $username, $password)

{

    $userTable = "employee";



    if (!isset($username) || !isset($password)) {

        return false;

    }



    $hashedPassword = md5($password);



    $sql = "SELECT * FROM $userTable WHERE userid = '$username' AND password = '$hashedPassword'";



    $query_result = $connection->query($sql);



    if (!$query_result) {

        die("Sorry, query is wrong");

    }



    $nrows = $query_result->num_rows;

    if ($nrows != 1) {

        return false;

    } else {

        return true;

    }

}

?>

