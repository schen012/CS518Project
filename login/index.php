<?php
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
                'highlight' => [
                    'fields' => [
                        '_all' => new \stdClass(),
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

 	foreach ($response['hits']['hits'] as $hit) {
            $highlight = isset($hit['highlight']) ? $hit['highlight']['_all'][0] : null;
            if ($highlight !== null) {
            } else {
            	}
          }
     }
}

?>

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
/*	    background-image: url(Anime_OnePiece_Wallpaper_StrawHatPirates_Complete-450x253.jpg); */
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
            background: linear-gradient(to right, #ff5733, #ff8c00, #ff5733);
            color: #fff;
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
            color: #fff;
        }
        .search-input:focus::placeholder {
            color: transparent;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="register.php">Signup</a>
        <a href="login.php">Login</a>
        <h1>CS518 Web Project</h1>
    </div>
    <div class="search-container">
        <form action="index.php" method="GET">
            <input type="text" class="search-input" name="query" placeholder="Search..." value="<?php echo htmlspecialchars($correctedQuery);?>">
   	    <button type="submit" class="search-button">Search</button>
        </form>
    </div>
    <div class="search-results">
    <?php
    if (isset($response['hits']['total']['value']) && $response['hits']['total']['value'] > 0) {
        echo '<p>Search results found:'  . $response['hits']['total']['value'] . '</p>';
	echo '<p>Original Query:' . $searchQuery . '</p>';

            // Check if there's a corrected query suggestion
    if (isset($response['suggest']['suggest']) && !empty($response['suggest']['suggest'][0]['options'])) {
        $correctedQuery = $response['suggest']['suggest'][0]['options'][0]['text'];
        echo '<p>Did you mean:'  . htmlspecialchars($correctedQuery) . '</p>';
    } elseif (strcasecmp($searchQuery, $correctedQuery) !== 0) {
        // If there's no suggestion but the query was corrected, display the suggestion
        echo '<p>Did you mean:'  . htmlspecialchars($correctedQuery) . '</p>';
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
