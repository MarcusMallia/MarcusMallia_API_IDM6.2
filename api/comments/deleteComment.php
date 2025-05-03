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

// Decode JSON body
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->comment_id)) {
    http_response_code(400);
    echo json_encode(["message" => "comment_id is required."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

// Verify comment belongs to user
$checkStmt = $conn->prepare("SELECT user_id FROM comments WHERE comment_id = :comment_id");
$checkStmt->bindParam(':comment_id', $data->comment_id);
$checkStmt->execute();
$result = $checkStmt->fetch(PDO::FETCH_ASSOC);

if (!$result || $result['user_id'] != $auth['user_id']) {
    http_response_code(403);
    echo json_encode(["message" => "Forbidden. You can only delete your own comments."]);
    exit;
}

// Proceed to delete
$stmt = $conn->prepare("DELETE FROM comments WHERE comment_id = :comment_id");
$stmt->bindParam(':comment_id', $data->comment_id);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(["message" => "Comment deleted successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to delete comment."]);
}