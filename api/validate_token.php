<?php
function validateToken() {
    $secret_key = "my_super_secret_key";

    $headers = getallheaders();

    if (!isset($headers['X-Access-Token'])) {
        http_response_code(401);
        echo json_encode(["message" => "X-Access-Token header missing."]);
        exit;
    }

    $authHeader = $headers['X-Access-Token'];

    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Invalid token format."]);
        exit;
    }

    $decoded = base64_decode($token, true);

    if (!$decoded) {
        http_response_code(401);
        echo json_encode(["message" => "Invalid token."]);
        exit;
    }

    $parts = explode(':', $decoded);
    if (count($parts) !== 2 || $parts[1] !== $secret_key) {
        http_response_code(401);
        echo json_encode(["message" => "Unauthorized access."]);
        exit;
    }

    $user_id = intval($parts[0]);

    return [
        "valid" => true,
        "user_id" => $user_id
    ];
}
?>