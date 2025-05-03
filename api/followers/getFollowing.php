<?php
require_once __DIR__ . '/../../db/Database.php';

header("Content-Type: application/json");

if (!isset($_GET['user_id'])) {
    http_response_code(400);
    echo json_encode(["message" => "user_id is required."]);
    exit;
}

$user_id = $_GET['user_id'];

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT f.user_id AS following_user_id, u.username
        FROM followers f
        JOIN users u ON f.user_id = u.user_id
        WHERE f.follower_user_id = :user_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

$following = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($following);