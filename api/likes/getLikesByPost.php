<?php
require_once __DIR__ . '/../../db/Database.php';

header("Content-Type: application/json");

if (!isset($_GET['post_id'])) {
    http_response_code(400);
    echo json_encode(["message" => "post_id is required."]);
    exit;
}

$post_id = $_GET['post_id'];

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT l.like_id, u.user_id, u.username
        FROM likes l
        JOIN users u ON l.user_id = u.user_id
        WHERE l.post_id = :post_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':post_id', $post_id);
$stmt->execute();

$likes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($likes);