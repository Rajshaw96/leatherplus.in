<?php
/**
 * Sends a WhatsApp message via the Aisensy API.
 * @param array $data The request body for the API call.
 * @return mixed The decoded JSON response from the API or an error message.
 */
function aisensyApiPost($data) {
    // Aisensy API endpoint
    $api_url = "https://backend.aisensy.com/campaign/t1/api/v2";

    // Initialize cURL session
    $ch = curl_init($api_url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);

    // Execute the cURL request
    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Check for cURL errors
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return ['error' => true, 'message' => "cURL Error: " . $error_msg];
    }

    // Close cURL session
    curl_close($ch);

    // Decode the response
    $responseData = json_decode($response, true);
    if ($http_status >= 400) {
        return ['error' => true, 'message' => $responseData['message'] ?? 'Unknown API Error'];
    }

    return $responseData;
}
?>