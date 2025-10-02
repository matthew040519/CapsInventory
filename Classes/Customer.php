<?php 

    class Customer {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getAllCustomers() {
            $stmt = $this->db->prepare("SELECT * FROM tblcustomer");
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function getCustomerById($id) {
            $stmt = $this->db->prepare("SELECT * FROM tblcustomer WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function countCustomers() {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS customer_count FROM tblcustomer");
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc()['customer_count'];
        }

        public function createCustomer($name, $address, $contact, $gender) {
            $stmt = $this->db->prepare("INSERT INTO tblcustomer (fullname, address, contact_no, gender) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $address, $contact, $gender);
            return $stmt->execute();
        }
    }