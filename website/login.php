<?php

include('authentication.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $loginUserId = $_POST['txtUserId'];

    $loginPassword = $_POST['txtPassword'];



    if (authenticateUser($conn, $loginUserId, $loginPassword)) {

        session_start();

        $_SESSION['db_is_logged_in'] = true;

        $_SESSION['userID'] = $loginUserId;



        header('Location: main.php');

        exit;

    } else {

        $errorMessage = 'Sorry, wrong username / password';

    }

}

?>



<!DOCTYPE html>

<html>

<head>

    <title>Login</title>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>

<body>

    <strong> <?php echo $errorMessage ?> </strong>

    If you don't have an account, please <a href="register.php">sign up</a>.

    <form action="" method="post" name="frmLogin" id="frmLogin">

        <table width="400" border="1" align="center" cellpadding="2" cellspacing="2">

            <tr>

                <td width="150">Admin ID</td>

                <td><input name="txtUserId" type="text" id="txtUserId"></td>

            </tr>

            <tr>

                <td width="150">Password</td>

                <td><input name="txtPassword" type="password" id="txtPassword"></td>

            </tr>

            <tr>

                <td width="150">&nbsp;</td>

                <td><input name="btnLogin" type="submit" id="btnLogin" value="Login"></td>

            </tr>

        </table>

    </form>

</body>

</html>

