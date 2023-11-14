<?php
require 'authentication.php';
$errorMessage = '';

session_start();
$errorMessage = '';
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
error_reporting(E_ALL);

ini_set('display_errors', 1);
require 'vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();

$pdfDirectory = 'PDF/';
$resultsPerPage = 10;
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

$from = ($currentPage - 1) * $resultsPerPage;

$correctedQuery = '';
$response = []; 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if a search query has been submitted
    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $searchQuery = $_GET['query'];
            $params = [
            'index' => 'your_index', 
            'body' => [
                'query' => [
                        'multi_match' => [
                            'query' => $searchQuery,
                            'fuzziness' => 'AUTO',
                    ],
                ],
                'size' => $resultsPerPage,
                'from' => $from,
            ],
	];
	$response = $client->search($params);
        // Get the corrected query from the response (if any)
        if (isset($response['suggest']['suggest'][0]['options'][0]['text'])) {
            $correctedQuery = $response['suggest']['suggest'][0]['options'][0]['text'];
        }
    }
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
		<z class = "pdfinput"><a href = "add.php" > Add Documents</a> </z>
            </div>
        </div>
        <div class="search-container">
        <form action="main.php" method="GET">
            <input type="text" class="search-input" name="query" placeholder="Search..." value="<?php echo htmlspecialchars($correctedQuery); ?>">
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>
    <div class="search-results">
    <?php
    if (isset($response['hits']['total']['value']) && $response['hits']['total']['value'] > 0) {
        echo '<p>Search results found: ' . $response['hits']['total']['value'] . '</p>';
        echo '<p>Original Query: ' . $searchQuery . '</p>';
            // Check if there's a corrected query suggestion
    if (isset($response['suggest']['suggest']) && !empty($response['suggest']['suggest'][0]['options'])) {
        $correctedQuery = $response['suggest']['suggest'][0]['options'][0]['text'];
        echo '<p>Did you mean: ' . htmlspecialchars($correctedQuery) . '</p>';
    } elseif (strcasecmp($searchQuery, $correctedQuery) !== 0) {
        // If there's no suggestion but the query was corrected, display the suggestion
        echo '<p>Did you mean: ' . htmlspecialchars($correctedQuery) . '</p>';
    }
     	echo '<ul>';
        if (isset($response['hits']['hits']) && is_array($response['hits']['hits'])) {
            foreach ($response['hits']['hits'] as $hit) {
                $document = $hit['_source'];
                echo '<li>';
                echo '<h2><a href="result_details.php?id=' . $hit['_id'] . '">' . $document['title'] . '</a></h2>';
                echo '</li>';
            }
	}
	echo '</ul>';
    } else {
	echo '<p>No search results found.</p>';
    }
    ?>

    <div class="pagination">
        <?php
         // Calculate
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        echo "Current Page: " . $currentPage . "<br>";
        $totalResults = $response['hits']['total']['value'] ?? 0;
        $totalPages = ceil($totalResults / $resultsPerPage);
if ($currentPage > 1) {
    echo '<a href="?query=' . htmlspecialchars($searchQuery) . '&page=1">' . " [<<] </a>";
}
    if ($currentPage > 1) {
        echo '<a href="?query=' . htmlspecialchars($searchQuery) . '&page=' . ($currentPage - 1) . '">' . " [<] </a>";
    }
    for ($page = 1; $page <= $totalPages; $page++) {
        if ($page == $currentPage) {
            echo '<span class="current">' . $page . '</span>';
        } else {
            echo '<a href="?query=' . htmlspecialchars($searchQuery) . '&page=' . $page . '">' . $page . '</a>';
        }
    }
    if ($currentPage < $totalPages) {
        echo '<a href="?query=' . htmlspecialchars($searchQuery) . '&page=' . ($currentPage + 1) . '">' . " [>] </a>";
    }
if ($currentPage < $totalPages) {
    echo '<a href="?query=' . htmlspecialchars($searchQuery) . '&page=' . $totalPages . '">' . " [>>] </a>";
}
 ?>
    </div>

    </div>
</body>
</html>
