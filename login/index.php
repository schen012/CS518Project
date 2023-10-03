<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home Page</title>

    <style>

        body {

            text-align: center;

            font-family: 'Arial', sans-serif;

            background-color: #f0f0f0;
//	    background-image: url(Anime_OnePiece_Wallpaper_StrawHatPirates_Complete-450x253.jpg);
            margin: 0;

            padding: 0;

            background-size: cover;

            background-repeat: no-repeat;

        }



        .header {

            background-color: #333;

            color: #fff;

            padding: 10px;

            display: flex;

            justify-content: space-between;

            align-items: center;

        }



        .header a {

            text-decoration: none;

            color: #fff;

            margin-right: 20px;

        }



        h1 {

            font-size: 24px;

            margin: 0;

        }



        .search-container {

            margin-top: 50px;

        }



        .search-input {

            padding: 15px;

            width: 400px;

            border: none;

            border-radius: 25px;

            font-size: 18px;

            outline: none;

            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);

            background: linear-gradient(to right, #ff5733, #ff8c00, #ff5733); /* Fire-like gradient */

            color: #fff; /* Text color */

        }



        .search-button {

            padding: 15px 25px;

            background-color: #007bff;

            color: #fff;

            border: none;

            border-radius: 25px;

            cursor: pointer;

            font-size: 18px;

            margin-left: 10px;

        }



        .search-input::placeholder {

            color: #fff; /* Placeholder text color */

        }



        .search-input:focus::placeholder {

            color: transparent; /* Hide placeholder text when focused */

        }

    </style>

</head>

<body>

    <div class="header">

        <div>

            <a href="register.php">Signup</a>

            <a href="login.php">Login</a>

        </div>

        <h1>CS518 Web Project</h1>

    </div>

    <div class="search-container">

        <form action="search.php" method="GET">

            <input type="text" class="search-input" name="query" placeholder="Search...">

            <button type="submit" class="search-button">Search</button>

        </form>

    </div>

</body>

</html>

