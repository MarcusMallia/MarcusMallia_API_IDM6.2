<?php
// Allow access from any origin (CORS policy)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// Allow POST method
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database connection
require_once '../../db/Database.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Check if required fields are set
if (
    !empty($data->user_id) &&
    !empty($data->content) &&
    !empty($data->title)
) {
    // Prepare SQL query
    $query = "INSERT INTO posts (user_id, content, link, title, tags, created_at, updated_at) 
              VALUES (:user_id, :content, :link, :title, :tags, NOW(), NOW())";

    $stmt = $db->prepare($query);

    // Bind parameters
    $stmt->bindParam(":user_id", $data->user_id);
    $stmt->bindParam(":content", $data->content);
    $stmt->bindParam(":link", $data->link);
    $stmt->bindParam(":title", $data->title);
    $stmt->bindParam(":tags", $data->tags);

    // Execute query
    if ($stmt->execute()) {
        http_response_code(201); // Created
        echo json_encode(["message" => "Post created successfully."]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Failed to create post."]);
    }

} else {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "Incomplete data."]);
}
?>