<?php

// Include database information and user information

require 'authentication.php';



// Never forget to start the session

session_start();

$errorMessage = 'Create a user account';



// Are user ID and Password provided?

if (isset($_POST['txtUserId']) && isset($_POST['txtPassword']) &&

    isset($_POST['retxtPassword'])) {



    // Get userID and Password

    $loginUserId = $_POST['txtUserId'];

    $loginPassword = $_POST['txtPassword'];

    $reLoginPassword = $_POST['retxtPassword'];

    $firstName = $_POST['firstName'];

    $lastName = $_POST['lastName'];

    $email = $_POST['email'];



    if ($loginPassword == $reLoginPassword) {



        // Connect to the database (make sure these variables are defined in authentication.php)

        $conn = new mysqli($server, $sqlUsername, $sqlPassword, $databaseName);



        // Table to store username and password

        $userTable = "employee";



        $ps = md5($loginPassword);



        // Formulate the SQL statement to insert the user data

        $sql = "INSERT INTO $userTable (userid, firstname, lastname, email, password) VALUES ('$loginUserId', '$firstName','$lastName', '$email', '$ps')";



        // Execute the query

        $query_result = $conn->query($sql);



        if (!$query_result) {

            die("SQL Query ERROR. User could not be created.");

        }



        // Go to the login page

        header('Location: login.php');

        exit;

    } else {

        $errorMessage = "Passwords do not match";

    }

}

?>



<html>

<head>

    <title>Sign-in</title>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>



<body>

<Strong> <?php echo $errorMessage ?> </Strong>



<form action="" method="post" name="frmLogin" id="frmLogin">

    <table width="300" border="1" align="center" cellpadding="2" cellspacing="2">

        <tr>

            <td width="150">Select Admin ID *</td>

            <td><input name="txtUserId" type="text" id="txtUserId"></td>

        </tr>

        <tr>

            <td width="150">Type Password *</td>

            <td><input name="txtPassword" type="password" id="txtPassword"></td>

        </tr>

        <tr>

            <td width="150">Retype Password *</td>

            <td><input name="retxtPassword" type="password" id="retxtPassword"></td>

        </tr>

        <tr>

            <td width="150">First Name</td>

            <td><input name="firstName" type="text" id="firstName"></td>

        </tr>

        <tr>

            <td width="150">Last Name</td>

            <td><input name="lastName" type="text" id="lastName"></td>

        </tr>

        <tr>

            <td width="150">Email Address</td>

            <td><input name="email" type="text" id="email"></td>

        </tr>

        <tr>

            <td width="150">&nbsp;</td>

            <td><input name="btnLogin" type="submit" id="btnLogin" value="Sign In"></td>

        </tr>

    </table>

</form>

</body>

</html>

