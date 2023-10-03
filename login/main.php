<?php

	session_start();



	//is the one accessing this page logged in or not?

	if (!isset($_SESSION['db_is_logged_in'])

		|| $_SESSION['db_is_logged_in'] != true) {

		// not logged in, move to login page

		header('Location: login.php');

		exit;

	} else {

		//logged in, display appropriate information

		// echo "Hello ",$_SESSION['userID'], "!";

	}

?>



<head>

    <title>Main User Page</title>

    <meta charset="UTF-8">

    <style>

        body {
            text-align: center;

            font-family: 'Arial', sans-serif;

            background-color: #f0f0f0;

            margin: 0;

            padding: 0;

            background-size: cover;

            background-repeat: no-repeat;
        }



        .container {

            max-width: 800px;

            margin: 0 auto;

            padding: 20px;
        }
        .header{
        }



        .user-profile-link {

            display: inline-block;

            width: 40px;

            height: 40px;

            border-radius: 50%;

            text-align: center;

            line-height: 40px;

            font-size: 20px;

            cursor: pointer;

            background-color: #007BFF;

            color: #fff;

            text-decoration: none;

        }



        .logout-link {

            text-align: center;

            margin-top: 10px; /* Add space between the profile icon and logout link */

        }



        .search-container {
            margin-top: 50px;
        }



        .search-input {
            padding: 15px;

            width: 710px;

            border: none;

            border-radius: 25px;

            font-size: 18px;

            outline: none;

            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);

            background: linear-gradient(to right, #ff5733, #ff8c00, #ff5733); /* Fire-like gradient */

            color: #fff; /* Text color */
        }



        .search-button {

            background-color: #007BFF;

            color: #fff;

            border: none;

            border-radius: 5px;

            padding: 5px 10px;

            cursor: pointer;

            font-size: 16px;

            margin-left: 5px;

        }



        h1 {

            color: #333;

        }



        p {

            color: #666;

            margin-bottom: 20px;

        }



        a {

            color: #007BFF;

            text-decoration: none;

        }



        a:hover {

            text-decoration: underline;

        }

    </style>

</head>



<body>

    <div class="container">

        <div class="header">

            <h1>CS 418/518</h1>

            <div>

                <a class="user-profile-link" href="profile.php">&#9786;</a>

                <p class="logout-link"><a href="index.php">Logout</a></p>

            </div>

        </div>

        <div class="search-container">

            <input type="text" class="search-input" placeholder="Search...">

            <button class="search-button">Search</button>

        </div>

    </div>

</body>



</html>


