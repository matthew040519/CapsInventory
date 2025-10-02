<?php


    class ProductTransaction {
        private $conn;
        private $table_name = "tblproduct_transactions";

        public function __construct($db) {
            $this->conn = $db;
        }

        // Function to add a new product transaction
        public function addTransaction($voucher, $product_id, $quantity, $date, $price, $supplier_id, $user_id) {
            $query = "INSERT INTO " . $this->table_name . " (voucher, product_id, quantity_in, date, price, supplier_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("siisdii", $voucher, $product_id, $quantity, $date, $price, $supplier_id, $user_id);
            return $stmt->execute();
        }

        public function sellProduct($voucher, $product_id, $quantity, $date, $discount, $price, $customer_id, $user_id) {

            $queryCheck = "SELECT id FROM tblcart WHERE customer_id = ? AND status_id = 1 LIMIT 1";
            $stmtCheck = $this->conn->prepare($queryCheck);
            $stmtCheck->bind_param("i", $customer_id);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();

            if ($resultCheck->num_rows === 0) {
                $queryInsertCart = "INSERT INTO tblcart (customer_id, date) VALUES (?, ?)";
                $stmtInsertCart = $this->conn->prepare($queryInsertCart);
                $stmtInsertCart->bind_param("is", $customer_id, $date);
                $stmtInsertCart->execute();
            }

            $query = "INSERT INTO " . $this->table_name . " (voucher, cart_id, product_id, quantity_out, date, discount, price, customer_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            // Get cart_id from tblcart
            $cart_id = null;
            if ($row = $resultCheck->fetch_assoc()) {
                $cart_id = $row['id'];
            } else {
                // Get the last inserted cart id
                $cart_id = $this->conn->insert_id;
            }

            $stmt->bind_param("siiisdidi", $voucher, $cart_id, $product_id, $quantity, $date, $discount, $price, $customer_id, $user_id);
            echo $stmt->execute();
        }

        // Function to get all product transactions
        public function getPDTransactions() {
            $query = "SELECT pt.id, p.product_name, pt.quantity_in, pt.date, pt.price, c.category_name
                      FROM " . $this->table_name . " pt
                      JOIN tblproducts p ON pt.product_id = p.id
                      JOIN tblcategories c ON p.category_id = c.id
                      WHERE pt.voucher = 'PD'
                      ORDER BY pt.date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function getCSTransactionsGroup()
        {
            $query = "SELECT tblcustomer.fullname, tblstatus.status_name, tblproduct_transactions.date, SUM(quantity_out * price) AS totalPrice, tblcustomer.id AS customer_id 
FROM tblproduct_transactions
JOIN tblcustomer ON tblcustomer.id=tblproduct_transactions.customer_id
JOIN tblstatus ON tblstatus.id=tblproduct_transactions.`status`
WHERE voucher = 'CS' GROUP BY customer_id, tblstatus.status_name, tblproduct_transactions.date
ORDER BY DATE DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function getCSTransactions()
        {
            $query = "SELECT pt.id, p.product_name, pt.quantity_out, pt.date, pt.discount, pt.price, cu.fullname, s.status_name AS status_name
                      FROM " . $this->table_name . " pt
                      JOIN tblproducts p ON pt.product_id = p.id
                      JOIN tblcustomer cu ON pt.customer_id = cu.id
                      JOIN tblstatus s ON pt.status_id = s.id
                      
                      WHERE pt.voucher = 'CS'
                      ORDER BY pt.date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function getCSTransactionById($id)
        {
            $query = "SELECT tblproduct_transactions.id, tblcustomer.id as CustomerId, discount, tblproducts.image, tblproducts.product_name, tblproducts.price, tblproduct_transactions.quantity_out 
FROM tblproduct_transactions
JOIN tblproducts ON tblproducts.id=tblproduct_transactions.product_id
JOIN tblcart ON tblcart.id=tblproduct_transactions.cart_id
JOIN tblcustomer ON tblcustomer.id=tblcart.customer_id
WHERE tblproduct_transactions.cart_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function sumCSTransactionsAll()
        {
            $query = "SELECT SUM(quantity_out * price) - SUM(discount) AS totalPrice FROM tblproduct_transactions WHERE voucher = 'CS'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc()['totalPrice'];
        }


        public function getAllCSTransactions()
        {
            $query = "SELECT tblproduct_transactions.id, tblcustomer.fullname, tblproduct_transactions.discount, tblproduct_transactions.date, tblproducts.product_name, tblproducts.price, tblproduct_transactions.quantity_out 
FROM tblproduct_transactions
JOIN tblproducts ON tblproducts.id=tblproduct_transactions.product_id
JOIN tblcart ON tblcart.id=tblproduct_transactions.cart_id
JOIN tblcustomer ON tblcustomer.id=tblcart.customer_id
ORDER BY tblproduct_transactions.date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function getInventory()
        {
            $query = "SELECT tblproducts.product_name, SUM(quantity_in - quantity_out) AS inventory FROM tblproduct_transactions
JOIN tblproducts ON tblproducts.id=tblproduct_transactions.product_id
GROUP BY product_id, product_name";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function getReOrderPointProducts()
        {
            $query = "SELECT p.product_name, (IFNULL(SUM(pt.quantity_in - pt.quantity_out), 0)) AS inventory, p.reorder_point
FROM tblproducts p
LEFT JOIN tblproduct_transactions pt ON p.id = pt.product_id
GROUP BY p.id
HAVING inventory < p.reorder_point";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->get_result();
    
        }
    }