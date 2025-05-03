<?php
require_once __DIR__ . '/../../db/Database.php';
require_once __DIR__ . '/../validate_token.php';

header("Content-Type: application/json");

// Auth check
$auth = validateToken();
if (!is_array($auth) || !$auth["valid"]) {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized"]);
    exit;
}

// Input check
$data = json_decode(file_get_contents("php://input"));
if (!isset($data->post_id) || !isset($data->url) || !isset($data->type)) {
    http_response_code(400);
    echo json_encode(["message" => "post_id, url, and type are required."]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

// Ownership check
$check = $conn->prepare("SELECT user_id FROM posts WHERE post_id = :post_id");
$check->bindParam(':post_id', $data->post_id);
$check->execute();
$post = $check->fetch(PDO::FETCH_ASSOC);

if (!$post || $post['user_id'] != $auth['user_id']) {
    http_response_code(403);
    echo json_encode(["message" => "Forbidden – You can only add links to your own posts."]);
    exit;
}

// Insert link
$stmt = $conn->prepare("INSERT INTO links (post_id, url, type) VALUES (:post_id, :url, :type)");
$stmt->bindParam(':post_id', $data->post_id);
$stmt->bindParam(':url', $data->url);
$stmt->bindParam(':type', $data->type);

if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode(["message" => "Link added to post successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to add link."]);
}