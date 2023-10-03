<?php
// Include database information and user information
require 'authentication.php';
// Start the session
session_start();
$errorMessage = '';
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if both username and password are provided
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Get the submitted username and password
        $username = $_POST['username'];
        $password = $_POST['password'];
        // Connect to the database
        $connection = new mysqli($server, $sqlUsername, $sqlPassword, $databaseName);
        // Check if the database connection was successful
        if ($connection->connect_error) {
            die("Database connection failed: " . $connection->connect_error);
        }
        // Authenticate the user
        if (authenticateUser($connection, $username, $password)) {
            // The username and password match, set the session
            $_SESSION['db_is_logged_in'] = true;
            $_SESSION['username'] = $username;
            // Redirect to the main page after successful login
            header('Location: main.php');
            exit;
        } else {
            $errorMessage = 'Sorry, wrong username or password';
        }
    } else {
        $errorMessage = 'Username and password are required';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Basic Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style>
        body {
            text-align: center;
            font-family: 'Arial', sans-serif;
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 400px;
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
        .signup-link {
            text-align: center;
        }
    </style>
</head>



<body>

    <div class="container">

        <h2>Login</h2>

        <form action="" method="post" name="frmLogin" id="frmLogin">

            <div class="form-group">

                <label for="txtUserId">User ID</label>

                <input name="username" type="text" id="username">

            </div>

            <div class="form-group">

                <label for="password">Password</label>

                <input name="password" type="password" id="password">

            </div>

            <div class="form-group">

                <input name="btnLogin" type="submit" id="btnLogin" value="Login">

            </div>

        </form>

<body>

    <div>

        <strong><?php echo $errorMessage; ?></strong>

    </div>

    If you don't have an account, please <a href="signup.php">sign up</a>.<br>

    <a href="forgotpassword.php">Forgot Password?</a> <!-- Link to the password reset page -->

 

</body>


    </div>

</body>

</html>


