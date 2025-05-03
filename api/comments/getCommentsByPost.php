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

$sql = "SELECT c.comment_id, c.user_id, u.username, c.content, c.created_at
        FROM comments c
        JOIN users u ON c.user_id = u.user_id
        WHERE c.post_id = :post_id
        ORDER BY c.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':post_id', $post_id);
$stmt->execute();

$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($comments);