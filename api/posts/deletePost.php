<?php
require_once '../../api/validate_token.php';

// Validate token
$user_id = validateToken();
// Allow access from any origin (CORS policy)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// Allow DELETE method
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database connection
require_once '../../db/Database.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Get DELETE data
$data = json_decode(file_get_contents("php://input"));

// Check if ID is provided
if (!empty($data->post_id)) {

    // Prepare SQL query
    $query = "DELETE FROM posts WHERE post_id = :id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $data->post_id, PDO::PARAM_INT);

    // Execute query
    if ($stmt->execute()) {
        http_response_code(200); // OK
        echo json_encode(["message" => "Post deleted successfully."]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Failed to delete post."]);
    }

} else {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "Missing post ID."]);
}
?>