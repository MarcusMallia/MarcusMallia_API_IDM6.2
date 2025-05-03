<?php
require_once __DIR__ . '/../../db/Database.php';
require_once __DIR__ . '/../validate_token.php';

header("Content-Type: application/json");

// Auth
$auth = validateToken();
if (!is_array($auth) || !$auth["valid"]) {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"));
if (!isset($data->user_id)) {
    http_response_code(400);
    echo json_encode(["message" => "user_id is required."]);
    exit;
}

$target_id = $data->user_id;
$current_id = $auth["user_id"];

$db = new Database();
$conn = $db->getConnection();

// Remove follow if exists
$stmt = $conn->prepare("DELETE FROM followers WHERE user_id = :user_id AND follower_user_id = :follower_id");
$stmt->bindParam(':user_id', $target_id);
$stmt->bindParam(':follower_id', $current_id);

if ($stmt->execute() && $stmt->rowCount() > 0) {
    http_response_code(200);
    echo json_encode(["message" => "Unfollowed successfully."]);
} else {
    http_response_code(404);
    echo json_encode(["message" => "You were not following this user."]);
}
