<?php
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

// Check if email and password are provided
if (!empty($data->email) && !empty($data->password)) {
    $email = $data->email;
    $password = $data->password;

    // Prepare SQL query
    $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if (password_verify($password, $row['password'])) {
            http_response_code(200); // OK
            echo json_encode([
                "message" => "Login successful.",
                "user_id" => $row['user_id'],
                "username" => $row['username'],
                "email" => $row['email']
            ]);
        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(["message" => "Invalid password."]);
        }

    } else {
        http_response_code(404); // Not Found
        echo json_encode(["message" => "User not found."]);
    }

} else {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "Email and password required."]);
}

// Generate token
$secret_key = "my_super_secret_key"; // You can change this key to anything more complex
$token_data = $row['user_id'] . ":" . $secret_key;
$token = base64_encode($token_data);

// Return JSON with token
http_response_code(200); // OK
echo json_encode([
    "message" => "Login successful.",
    "token" => $token,
    "user_id" => $row['user_id'],
    "username" => $row['username'],
    "email" => $row['email']
]);
?>