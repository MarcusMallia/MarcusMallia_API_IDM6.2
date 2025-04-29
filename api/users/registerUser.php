<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Allow access from any origin
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
    !empty($data->username) &&
    !empty($data->email) &&
    !empty($data->password)
) {
    // Hash password
    $hashed_password = password_hash($data->password, PASSWORD_DEFAULT);

    // Prepare SQL query
    $query = "INSERT INTO users (username, email, password, created_at, updated_at) 
              VALUES (:username, :email, :password, NOW(), NOW())";

    $stmt = $db->prepare($query);

    // Bind parameters
    $stmt->bindParam(":username", $data->username);
    $stmt->bindParam(":email", $data->email);
    $stmt->bindParam(":password", $hashed_password);

    // Execute query
    if ($stmt->execute()) {
        http_response_code(201); // Created
        echo json_encode(["message" => "User registered successfully."]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Failed to register user."]);
    }

} else {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "Incomplete data."]);
}
?>