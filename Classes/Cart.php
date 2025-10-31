<?php 

    class Cart {
        private $conn;
        private $table_name = "tblcart";

        public function __construct($db) {
            $this->conn = $db;
        }

        public function addToCart($product_id, $quantity, $user_id) {
            $query = "INSERT INTO " . $this->table_name . " (product_id, quantity, user_id) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iii", $product_id, $quantity, $user_id);
            return $stmt->execute();
        }

        public function getCartItems($user_id) {
            $query = "SELECT c.id, p.product_name, p.price, c.quantity, (p.price * c.quantity) AS total_price 
                      FROM " . $this->table_name . " c 
                      JOIN tblproducts p ON c.product_id = p.id 
                      WHERE c.user_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function getTransactionItems($cart_id) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $cart_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function clearCart($user_id) {
            $query = "DELETE FROM " . $this->table_name . " WHERE user_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            return $stmt->execute();
        }

        public function getTotalAmount($user_id) {
            $query = "SELECT SUM(p.price * c.quantity) AS total_amount 
                      FROM " . $this->table_name . " c 
                      JOIN tblproducts p ON c.product_id = p.id 
                      WHERE c.user_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc()['total_amount'];
        }
    }