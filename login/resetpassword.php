<?php
	//include information required to access database
	require 'authentication.php'; 
	//start a session 
	session_start();
// Initialize variables
$message = '';
// Connect to the database
$connection = new mysqli($server, $sqlUsername, $sqlPassword, $databaseName);
// Function to change the password
function changePassword($connection, $userID, $newPassword)
{
    // Hash the new password (you can use password_hash for better security)
    $hashedPassword = md5($newPassword); // Change this to use password_hash
    // Update the password in the user table
    $userTable = "users";
    $sql = "UPDATE $userTable SET password = '$hashedPassword' WHERE username = '$userID'";
    if ($connection->query($sql) === TRUE) {
        return true; // Password updated successfully
    } else {
        return false; // Error updating password
    }
}
// Handle password change form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'];
    // Add validation for the new password here if needed
    // Attempt to change the password
    if (changePassword($connection, $_SESSION['username'], $newPassword)) {
        // Password changed successfully
        $errorMessage = "Password changed successfully!";
    } else {
        // Error changing password
        $errorMessage = "Error changing password.";
    }
}
// Close the database connection
$connection->close();
?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Password Reset</title>

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



        input[type="password"] {

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

        <h1>Password Reset</h1>

        <p>Enter your new password below:</p>

        <form method="post" action="">

            <label for="new_password">New Password:</label>

            <input type="password" name="new_password" required>

            <button type="submit">Change Password</button>

        </form>

        <p class="message"><?php echo $errorMessage; ?></p>

        <a href="login.php" class="back-link">Back to Login</a>

    </div>

</body>

</html>

