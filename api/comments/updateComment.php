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

// Get JSON input
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->comment_id) || !isset($data->new_content)) {
    http_response_code(400);
    echo json_encode(["message" => "comment_id and new_content are required."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

// Check ownership
$checkStmt = $conn->prepare("SELECT user_id FROM comments WHERE comment_id = :comment_id");
$checkStmt->bindParam(':comment_id', $data->comment_id);
$checkStmt->execute();
$result = $checkStmt->fetch(PDO::FETCH_ASSOC);

if (!$result || $result['user_id'] != $auth['user_id']) {
    http_response_code(403);
    echo json_encode(["message" => "Forbidden. You can only update your own comments."]);
    exit;
}

// Update comment
$updateStmt = $conn->prepare("UPDATE comments SET content = :content, updated_at = NOW() WHERE comment_id = :comment_id");
$updateStmt->bindParam(':content', $data->new_content);
$updateStmt->bindParam(':comment_id', $data->comment_id);

if ($updateStmt->execute()) {
    http_response_code(200);
    echo json_encode(["message" => "Comment updated successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to update comment."]);
}