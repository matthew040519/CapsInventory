<?php 


    class Order{
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getAllOrders() {
            $stmt = $this->db->prepare("SELECT tblcart.id AS OrderId, tblcustomer.fullname, tblstatus.status_name, tblstatus.id as StatusId, tblcart.date FROM tblcart
                    JOIN tblcustomer ON tblcustomer.id=tblcart.customer_id
                    JOIN tblstatus ON tblstatus.id=tblcart.status_id
                    ORDER BY tblcart.date DESC");
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function getOrderById($id) {
            $stmt = $this->db->prepare("SELECT * FROM tblcart WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function countOrders() {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS order_count FROM tblcart");
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc()['order_count'];
        }

        public function checkoutOrder($order_id, $user_id) {
            $status_id = 4; // Assuming '4' is the ID for 'Completed' status
            $stmt = $this->db->prepare("UPDATE tblcart SET status_id = ?, user_id = ? WHERE id = ?");
            $stmt->bind_param("iii", $status_id, $user_id, $order_id);
            return $stmt->execute();
        }
    }