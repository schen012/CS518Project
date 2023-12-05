
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the input data as JSON
    $inputData = json_decode(file_get_contents('php://input'), true);
  // Check if the 'prompt' key exists in the input data
//document.write($inputData);

    if (isset($inputData['prompt'])) {
        $prompt = $inputData['prompt'];

      // Call the function to interact with GPT-3.5-turbo
        $chatbotResponse = chatWithGPT($prompt);

//	document.write($chatbotResponse);
        // Return the chatbot response as JSON
        header('Content-Type: application/json');
        echo json_encode($chatbotResponse);
        exit;
    }
}
// Function to interact with the GPT-3.5-turbo API
function chatWithGPT($prompt) {
    $url = 'https://api.openai.com/v1/engines/gpt-3.5-turbo/completions';
    $apiKey = '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'; // Replace with your actual OpenAI API key
    $data = [
        'prompt' => $prompt,
        'max_tokens' => 150, // Adjust as needed
    ];
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ];
    $options = [
        'http' => [
            'header' => implode("\r\n", $headers),
            'method' => 'POST',
            'content' => json_encode($data),
        ],
    ];
    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context); 
//document.write($context);
    if ($result === FALSE) {
        // Handle error and log details
        $error = error_get_last();
        $errorMessage = 'Error communicating with the GPT-3.5-turbo API: ' . $error['message'];
        error_log($errorMessage, 0); // Log the error
        return ['error' => $errorMessage];
    }
    $response = json_decode($result, true);
    if (isset($response['choices'][0]['text'])) {
        return ['text' => $response['choices'][0]['text']];
    } else {
        // Handle unexpected response
        $errorMessage = 'Unexpected response from the GPT-3.5-turbo API';
        error_log($errorMessage, 0); // Log the error
        return ['error' => $errorMessage];
    }
}
?>
