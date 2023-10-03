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



        // Redirect to the login

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

		   <td width="150">Select User ID *</td>

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



		  <tr>

		   <td width="150">Last Name</td>

		   <td><input name="lastName" type="text" id="lastName"></td>

		  </tr>

		  <tr>

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

