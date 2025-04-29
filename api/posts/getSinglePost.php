<?php
// Allow access from any origin (CORS policy)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database connection
require_once '../../db/Database.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Check if ID parameter exists
if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);

    // Prepare SQL query
    $query = "SELECT * FROM posts WHERE post_id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $post_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Prepare the post data
        $post_item = [
            "post_id" => $row['post_id'],
            "user_id" => $row['user_id'],
            "content" => $row['content'],
            "link" => $row['link'],
            "created_at" => $row['created_at'],
            "updated_at" => $row['updated_at'],
            "title" => $row['title'],
            "tags" => $row['tags']
        ];

        http_response_code(200); // OK
        echo json_encode($post_item);

    } else {
        http_response_code(404); // Not Found
        echo json_encode(["message" => "Post not found."]);
    }

} else {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "Missing post ID parameter."]);
}
?>