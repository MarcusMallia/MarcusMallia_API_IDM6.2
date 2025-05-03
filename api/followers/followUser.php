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

if ($target_id == $current_id) {
    http_response_code(400);
    echo json_encode(["message" => "You cannot follow yourself."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

// Check if already following
$check = $conn->prepare("SELECT * FROM followers WHERE user_id = :user_id AND follower_user_id = :follower_id");
$check->bindParam(':user_id', $target_id);
$check->bindParam(':follower_id', $current_id);
$check->execute();

if ($check->rowCount() > 0) {
    http_response_code(409);
    echo json_encode(["message" => "You already follow this user."]);
    exit;
}

// Insert follow
$stmt = $conn->prepare("INSERT INTO followers (user_id, follower_user_id) VALUES (:user_id, :follower_id)");
$stmt->bindParam(':user_id', $target_id);
$stmt->bindParam(':follower_id', $current_id);

if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode(["message" => "User followed successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to follow user."]);
}