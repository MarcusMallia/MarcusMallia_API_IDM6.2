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
if (!isset($data->post_id) || !isset($data->content)) {
    http_response_code(400);
    echo json_encode(["message" => "post_id and content are required."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$sql = "INSERT INTO comments (post_id, user_id, content) VALUES (:post_id, :user_id, :content)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':post_id', $data->post_id);
$stmt->bindParam(':user_id', $auth["user_id"]);
$stmt->bindParam(':content', $data->content);

if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode(["message" => "Comment added successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to add comment."]);
}