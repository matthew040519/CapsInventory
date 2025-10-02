<?php 


class DB {
    private $host = 'localhost';
    private $db_name = 'caps_inventory_db';
    private $username = 'root';
    private $password = '';

    public function connect() {
        $conn = null;
        try {
            $conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
            }
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $conn;
    }
}