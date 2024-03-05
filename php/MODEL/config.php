<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'perpus';
    private $conn;

    // Constructor
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Get connection
    public function getConnection() {
        return $this->conn;
    }

    // Close connection
    public function closeConnection() {
        $this->conn->close();
    }
}

// Example usage:
$database = new Database();
$conn = $database->getConnection();

// When done, close the connection
// $database->closeConnection();
?>
