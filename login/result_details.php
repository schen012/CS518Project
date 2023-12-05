<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'vendor/autoload.php';
use Elasticsearch\ClientBuilder;
// Function to interact with the GPT-3.5 API
$client = Elasticsearch\ClientBuilder::create()->build();
$pdfDirectory = 'PDF/';
$displayFullInfo = false;
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $resultId = $_GET['id'];
    $params = [
        'index' => 'your_index',
        'body' => [
            'query' => [
                'ids' => [
                    'values' => [$resultId],
                ],
            ],
        ],
    ];
    try {
        $response = $client->search($params);
        if (isset($response['hits']['hits'][0])) {
            $document = $response['hits']['hits'][0]['_source'];
            $displayFullInfo = true;
        }
    } catch (Exception $e) {
        echo "Error executing Elasticsearch query: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Details</title>
    <style>

    </style>

</head>
<body>
    <div class="header">
        <a href="index.php">Back to Search Results</a>
        <h1>Result Details</h1>
    </div>
    <?php if ($displayFullInfo) : ?>
        <h2>Full Information</h2>
        <p>Title: <?php echo htmlspecialchars($document['title']); ?></p>
        <p>Author: <?php echo htmlspecialchars($document['author']); ?></p>
        <p>Year: <?php echo htmlspecialchars($document['year']); ?></p>
        <p>University: <?php echo htmlspecialchars($document['university']); ?></p>
        <p>Program: <?php echo htmlspecialchars($document['program']); ?></p>
        <p>Degree: <?php echo htmlspecialchars($document['degree']); ?></p>
        <p>Advisor: <?php echo htmlspecialchars($document['advisor']); ?></p>
        <p>Abstract: <?php echo htmlspecialchars($document['abstract']); ?></p>
        <p><a href="<?php echo $pdfDirectory . $resultId . '.pdf' ?>">Download PDF</a></p>
    <?php else : ?>
        <p>Result not found.</p>
    <?php endif; ?>
             <!-- Collapsible chat window toggle button -->

        <button id="chat-toggle" onclick="toggleChat()">Chat</button>

        <!-- Collapsible chat window -->

        <div id="chat-window" style="position: fixed; bottom: 0; right: 0; max-width: 300px; background-color: #fff; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

            <div id="chat-header" style="background-color: #4CAF50; color: #fff; padding: 10px; cursor: pointer;" onclick="toggleChat()">Chat</div>

            <div id="chat-body" style="display: none; padding: 10px;">

                <div id="chat-messages" style="max-height: 200px; overflow-y: auto;"></div>

                <input type="text" id="chat-input" style="width: 100%; margin-top: 10px;" placeholder="Type your message...">

                <button id="send-button" onclick="sendMessage()">Send</button>

            </div>

        </div>

       <script>



    function toggleChat() {

                var chatBody = document.getElementById('chat-body');

                var chatToggle = document.getElementById('chat-header');

                if (chatBody.style.display === 'block' || chatBody.style.display === '') {

                    // If chat is open or not set, close it

                    chatBody.style.display = 'none';

                    chatToggle.style.backgroundColor = '#4CAF50';

                } else {

                    // If chat is closed, open it

                    chatBody.style.display = 'block';

                    chatToggle.style.backgroundColor = '#555';

                }

            }
   function sendMessage() {
                var inputElement = document.getElementById('chat-input');
                var message = inputElement.value;
                if (message.trim() !== '') {
                    // Append the message to the chat window
                    var messagesContainer = document.getElementById('chat-messages');
                    messagesContainer.innerHTML += '<div><strong>You:</strong> ' + message + '</div>';
                    // Clear the input field
                    inputElement.value = '';
                    // Send user's question to the chatbot
                    var userQuestion = message;
                    var initialPrompt = "Read the abstract of this thesis titled <?php echo htmlspecialchars($document['title']); ?>: <?php echo htmlspecialchars($document['abstract']); ?>. Answer the following questions from the reader. Question: " + userQuestion;
                    fetch('gptAPI.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ prompt: initialPrompt }),
                    })
                    .then(response => response.json())
                    .then(data => {
			    var chatbotResponse = data.text;
    			// Append the message to the chat window
    			messagesContainer.innerHTML += '<div><strong>Chatbot:</strong> ' + chatbotResponse + '</div>';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

                }

            }

</script>

</body>

</html>
