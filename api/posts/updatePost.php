<?php
// Allow access from any origin (CORS policy)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// Allow PATCH method
header("Access-Control-Allow-Methods: PATCH");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database connection
require_once '../../db/Database.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Get PATCH data
$data = json_decode(file_get_contents("php://input"));

// Check if ID is provided
if (!empty($data->post_id)) {

    // Prepare SQL query
    $query = "UPDATE posts 
              SET content = :content,
                  link = :link,
                  title = :title,
                  tags = :tags,
                  updated_at = NOW()
              WHERE post_id = :id";

    $stmt = $db->prepare($query);

    // Bind parameters
    $stmt->bindParam(":content", $data->content);
    $stmt->bindParam(":link", $data->link);
    $stmt->bindParam(":title", $data->title);
    $stmt->bindParam(":tags", $data->tags);
    $stmt->bindParam(":id", $data->post_id, PDO::PARAM_INT);

    // Execute query
    if ($stmt->execute()) {
        http_response_code(200); // OK
        echo json_encode(["message" => "Post updated successfully."]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Failed to update post."]);
    }

} else {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "Missing post ID."]);
}
?>