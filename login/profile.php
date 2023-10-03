
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
	    border-bottom: none;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }
        h1 {
            margin: 0;
        }
        nav {
            text-align: center;
            margin-top: 20px;
        }
        nav a {
            text-decoration: none;
            color: #fff;
            margin: 0 10px;
        }
        nav a:hover {
            color: blue;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        .action-link {
            text-align: center;
            margin-top: 20px;
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
               //include information required to access database
        require 'authentication.php'; 
        //start a session 
        session_start();
        //still logged in?
        if (!isset($_SESSION['db_is_logged_in'])
                || $_SESSION['db_is_logged_in'] != true) {
                //not logged in, move to login page
                header('Location: login.php');
                exit;
        }else {
    //logged in
        // Connect database server
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
        // Output query results: HTML table
        echo "<table border=1>";
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
    // close the connection
    $conn->close();
    // Add a link to the change password page
     echo '<p><a href="changepassword.php"></a></p>';
        }

 ?>
    </div>

</body>

</html>
