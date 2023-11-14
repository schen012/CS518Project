<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title> User Profile</title>

    <style>

        body {

            font-family: Arial, sans-serif;

            background-color: #f0f0f0;

            margin: 0;

            padding: 0;

            display: flex;

            justify-content: center;

            align-items: center;

            height: 100vh;

        }

        .container {

            background-color: #fff;

            border-radius: 5px;

            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);

            padding: 20px;

            max-width: 600px;

            width: 100%;

            text-align: center;

        }

        header {

            background-color: #3498db;

            color: #fff;

            padding: 20px 0;

        }

        h1 {

            margin: 0;

            font-size: 24px;

        }

        nav {

            text-align: left;

            margin-top: 20px;

        }

        nav a {

            text-decoration: none;
	    background-color:#3498db;
            color: #fff;
	    padding: 10px 20px;

            border-radius: 5px;

            font-weight: bold;

            display: block; 

            margin-bottom: 10px; 

        }

        nav a:hover {

            color: #2980b9;

        }

        table {

            width: 100%;

            border-collapse: collapse;

            margin-top: 20px;

        }

        th, td {

            padding: 12px;

            text-align: left;

            border-bottom: 1px solid #ddd;

        }

        th {

            background-color: #3498db;

            color: #fff;

        }
    </style>

</head>

<body>

    <header>

        <h1>User Profile</h1>

        <nav>

            <a href="main.php">Main</a>

            <a href="changepassword.php">Change Password</a>

            <a href="logout.php">Logout</a>

        </nav>

    </header>

    <div class="container">

        <?php

        //include information required to access the database

        require 'authentication.php'; 

        //start a session 

        session_start();

        //still logged in?

        if (!isset($_SESSION['db_is_logged_in']) || $_SESSION['db_is_logged_in'] != true) {

            //not logged in, redirect to the login page

            header('Location: login.php');

            exit;

        } else {

            //logged in

            // Connect to the database server

            $conn = new mysqli($server, $sqlUsername, $sqlPassword, $databaseName);

            // Prepare query

            $table = "users";

            $uid = $_SESSION['username'];

            $sql = "SELECT username, firstname, lastname, email FROM $table WHERE username = '$uid'";

            // Execute query

            $query_result = $conn->query($sql);

            if (!$query_result) {

                echo "Query is wrong: $sql";

                die;

            }

            // Output query results in an HTML table

            echo "<table>";

            echo "<tr>";

            // fetch attribute names

            while ($fieldMetadata = $query_result->fetch_field()) {

                echo "<th>".$fieldMetadata->name."</th>";

            }

            echo "</tr>";

            // fetch table records

            while ($line = $query_result->fetch_assoc()) {

                echo "<tr>\n";

                foreach ($line as $cell) {

                    echo "<td> $cell </td>";

                }

                echo "</tr>\n";

            }

            echo "</table>";

            // Close the database connection

            $conn->close();

            // Add a link to the change password page

           // echo '<p class="action-link"><a href="main.php">Main</a></p>';
	  //  echo '<p class="action-link"><a href="changepassword.php">Change Password</a></p>';
	 //   echo '<p class="action-link"><a href"logout.php">Logout</a></p>';
        }

        ?>

    </div>

</body>

</html>

