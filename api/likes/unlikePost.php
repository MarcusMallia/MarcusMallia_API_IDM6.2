<?php
require_once __DIR__ . '/../../db/Database.php';
require_once __DIR__ . '/../validate_token.php';

header("Content-Type: application/json");

// Validate token
$auth = validateToken();
if (!is_array($auth) || !isset($auth["valid"]) || !$auth["valid"]) {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"));
if (!isset($data->post_id)) {
    http_response_code(400);
    echo json_encode(["message" => "post_id is required."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

// Delete like if it exists
$stmt = $conn->prepare("DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id");
$stmt->bindParam(':user_id', $auth["user_id"]);
$stmt->bindParam(':post_id', $data->post_id);

if ($stmt->execute() && $stmt->rowCount() > 0) {
    http_response_code(200);
    echo json_encode(["message" => "Like removed successfully."]);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Like not found or already removed."]);
}