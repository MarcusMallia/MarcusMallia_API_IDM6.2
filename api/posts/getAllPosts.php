<?php
// Allow access from any origin (CORS policy)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database connection
require_once '../../db/Database.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Query to fetch all posts
$query = "SELECT * FROM posts ORDER BY created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute();

// Check if there are results
if ($stmt->rowCount() > 0) {
    $posts_array = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = [
            "post_id" => $post_id,
            "user_id" => $user_id,
            "content" => $content,
            "link" => $link,
            "created_at" => $created_at,
            "updated_at" => $updated_at,
            "title" => $title,
            "tags" => $tags
        ];

        $posts_array[] = $post_item;
    }

    http_response_code(200); // OK
    echo json_encode($posts_array);

} else {
    http_response_code(404); // Not Found
    echo json_encode(["message" => "No posts found."]);
}
?>