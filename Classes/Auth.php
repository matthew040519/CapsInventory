<?php 


Class Login {

    private $username;
    private $password;
    private $db;

    public function __construct($username, $password, $db) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: index.php');
            exit();
        }
    }

    public static function logout() {
        session_unset();
        session_destroy();
        header('Location: ../../index.php');
        exit();
    }

    public static function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    public function login() {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($this->password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];

                return true;
            }
        }
        return false;
    }

    public function register($email) {
        $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $this->username, $email, $hashed_password);
        return $stmt->execute();
    }
}