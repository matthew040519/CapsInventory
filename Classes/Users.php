<?php 


class Users {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getUser()
    {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function createUser($username, $password, $email, $role, $filename, $fullname) {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, email, role, image, fullname) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, password_hash($password, PASSWORD_BCRYPT), $email, $role, $filename, $fullname);
        return $stmt->execute();
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateUser($id, $username, $email, $fullname) {
        $stmt = $this->db->prepare("UPDATE users SET username = ?, email = ?, fullname = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $email, $fullname, $id);
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Add user-related methods here, e.g., createUser, getUser, updateUser, deleteUser
}