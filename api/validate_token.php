<?php
function validateToken() {
    $secret_key = "my_super_secret_key";

    if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
        http_response_code(401);
        echo json_encode(["message" => "Authorization header missing."]);
        exit;
    }

    // Extract Bearer token
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Invalid authorization header format."]);
        exit;
    }

    // Decode token
    $decoded = base64_decode($token);
    if (!$decoded) {
        http_response_code(401);
        echo json_encode(["message" => "Invalid token."]);
        exit;
    }

    // Check token structure
    $parts = explode(':', $decoded);
    if (count($parts) !== 2 || $parts[1] !== $secret_key) {
        http_response_code(401);
        echo json_encode(["message" => "Unauthorized access."]);
        exit;
    }

    // Return the user_id from token
    return $parts[0];
}
?>