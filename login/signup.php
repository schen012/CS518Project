<?php

// Include database information and user information
require 'authentication.php';
// Never forget to start the session
session_start();
$errorMessage = 'Create a user account';
// Check if the user ID and Password are provided
if (isset($_POST['txtUserId']) && isset($_POST['txtPassword']) &&
    isset($_POST['retxtPassword'])) {
    // Get user input
    $loginUserId = $_POST['txtUserId'];
    $loginPassword = $_POST['txtPassword'];
    $reLoginPassword = $_POST['retxtPassword'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    // Connect to the database
    $conn = new mysqli($server, $sqlUsername, $sqlPassword, $databaseName);
    // Check if the database connection was successful
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }



    // Check if the passwords match

    if ($loginPassword == $reLoginPassword) {

        // Hash the password

        $ps = md5($loginPassword);



        // Always insert into the user_registration_requests table

        $userTable = "user_registration_requests";



        // Formulate the SQL statement to insert the data

        $sql = "INSERT INTO $userTable (username, password, firstname, lastname, email) 

                VALUES ('$loginUserId', '$ps', '$firstName', '$lastName', '$email')";



        // Execute the query

        $query_result = $conn->query($sql);



        if (!$query_result) {

            die("SQL Query ERROR. User registration request could not be created.");

        }



        // Redirect to the registration confirmation page

        header('Location: login.php');

        exit;

    } else {

        $errorMessage = "Passwords do not match";

    }

}

?>


<!DOCTYPE html>

<html>

<head>

    <title>Sign Up</title>

    <meta charset="UTF-8">

    <style>

        body {

            font-family: Arial, sans-serif;

            background-color: #f2f2f2;

        }



        .container {

            width: 300px;

            margin: 0 auto;

            padding: 20px;

            background-color: #fff;

            border: 1px solid #ccc;

            border-radius: 5px;

            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);

        }



        h2 {

            text-align: center;

        }



        .form-group {

            margin-bottom: 20px;

        }



        label {

            display: block;

            font-weight: bold;

        }



        input[type="text"],

        input[type="password"] {

            width: 95%;

            padding: 10px;

            border: 1px solid #ccc;

            border-radius: 3px;

        }



        input[type="submit"] {

            width: 100%;

            padding: 10px;

            background-color: #007bff;

            color: #fff;

            border: none;

            border-radius: 3px;

            cursor: pointer;

        }



        input[type="submit"]:hover {

            background-color: #0056b3;

        }



        .error-message {

            color: red;

            text-align: center;

        }

    </style>

</head>



<body>

    <div class="container">

        <h2>Sign Up</h2>

        <form action="" method="post" name="frmSignup" id="frmSignup">

            <div class="form-group">

                <label for="txtUserId">User ID *</label>

                <input name="txtUserId" type="text" id="txtUserId">

            </div>

            <div class="form-group">

                <label for="txtPassword">Password *</label>

                <input name="txtPassword" type="password" id="txtPassword">

            </div>

            <div class="form-group">

                <label for="retxtPassword">Retype Password *</label>

                <input name="retxtPassword" type="password" id="retxtPassword">

            </div>

            <div class="form-group">

                <label for="firstName">First Name</label>

                <input name="firstName" type="text" id="firstName">

            </div>

            <div class="form-group">

                <label for="lastName">Last Name</label>

                <input name="lastName" type="text" id="lastName">

            </div>

            <div class="form-group">

                <label for="email">Email Address</label>

                <input name="email" type="text" id="email">

            </div>

            <div class="form-group">

                <input name="btnSignup" type="submit" id="btnSignup" value="Sign Up">

            </div>

        </form>

        <div class="error-message">

            <?php echo $errorMessage; ?>

        </div>

    </div>

</body>

</html>

