<?php
// db/Database.php

class Database {
    // Database credentials
    private $host = 'localhost';
    private $db_name = 'speakeasysounds_api';
    private $username = 'root';    // Default MAMP username
    private $password = 'root';    // Default MAMP password (on MAMP, both user and pass are usually 'root')
    public $conn;

    // Get the database connection
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8mb4");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>