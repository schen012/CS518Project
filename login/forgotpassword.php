<?php
// Include any necessary authentication and database connection code here
require 'authentication.php';
session_start();
// Initialize variables
$message = '';
// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    // Validate the email address (you can add more robust validation)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } else {
        // Check if the email exists in the database (you may need to customize this)
        $conn = new mysqli($server, $sqlUsername, $sqlPassword, $databaseName);
        $sql = "SELECT username FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            // Email found in the database, proceed to reset password
            // Generate a temporary password or a reset token and update the user's password
            // You should implement this logic here
            // Redirect to the password reset confirmation page
            header('Location: resetpassword.php');
            exit();
        } else {
            // Email not found in the database
            $message = 'Email address not found.';
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password</title>

    <style>

        /* Global styles */

        body {

            font-family: 'Helvetica Neue', Arial, sans-serif;

            background-color: #f4f4f4;

            margin: 0;

            padding: 0;

            display: flex;

            justify-content: center;

            align-items: center;

            height: 100vh;

        }



        .container {

            max-width: 400px;

            background-color: #fff;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);

            padding: 20px;

            border-radius: 10px;

            text-align: center;

        }



        h1 {

            font-size: 24px;

            color: #333;

            margin-bottom: 20px;

        }



        /* Form styles */

        label {

            display: block;

            font-size: 16px;

            color: #333;

            margin-bottom: 10px;

        }



        input[type="email"] {

            width: 95%;

            padding: 10px;

            margin-bottom: 20px;

            border: 1px solid #ccc;

            border-radius: 5px;

            font-size: 16px;

        }



        button[type="submit"] {

            background-color: #0070c9;

            color: #fff;

            border: none;

            border-radius: 5px;

            padding: 12px 20px;

            font-size: 18px;

            cursor: pointer;

        }



        button[type="submit"]:hover {

            background-color: #005baa;

        }



        /* Message styles */

        .message {

            font-size: 18px;

            color: #333;

            margin-top: 20px;

        }



        /* Back to Login link */

        .back-link {

            margin-top: 20px;

            font-size: 16px;

            color: #0070c9;

            text-decoration: none;

            display: block;

        }



        .back-link:hover {

            text-decoration: underline;

        }

    </style>

</head>

<body>

    <div class="container">

        <h1>Forgot Password</h1>

        <p>Enter your email address to reset your password.</p>

        <form method="post" action="">

            <label for="email">Email:</label>

            <input type="email" name="email" required>

            <button type="submit">Reset Password</button>

        </form>

        <p class="message"><?php echo $message; ?></p>

        <a href="login.php" class="back-link">Back to Login</a>

    </div>

</body>

</html>

