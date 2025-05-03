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

// Get input
$data = json_decode(file_get_contents("php://input"));
if (!isset($data->post_id)) {
    http_response_code(400);
    echo json_encode(["message" => "post_id is required."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

// Prevent duplicate likes
$checkStmt = $conn->prepare("SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id");
$checkStmt->bindParam(':user_id', $auth["user_id"]);
$checkStmt->bindParam(':post_id', $data->post_id);
$checkStmt->execute();

if ($checkStmt->rowCount() > 0) {
    http_response_code(409);
    echo json_encode(["message" => "You have already liked this post."]);
    exit;
}

// Insert like
$stmt = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)");
$stmt->bindParam(':user_id', $auth["user_id"]);
$stmt->bindParam(':post_id', $data->post_id);

if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode(["message" => "Post liked successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to like post."]);
}