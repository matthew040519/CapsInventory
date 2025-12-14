<?php 


    class Projects {
        private $conn;

        public function __construct($dbConnection) {
            $this->conn = $dbConnection;
        }

        public function getAllProjects() {
            $query = "SELECT *, tblprojects.id as project_id, tblprojects.tdate as tdate, tblprojects.project_name as project_name,
            (CASE WHEN tblprojects.status = 1 THEN 'Ongoing' WHEN tblprojects.status = 0 THEN 'Pending' WHEN tblprojects.status = 2 THEN 'Completed' ELSE 'Rejected' END) AS status_text
             FROM tblprojects INNER JOIN tblcustomer ON tblprojects.customer_id = tblcustomer.id ORDER BY tblprojects.id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $projects = [];
            while ($row = $result->fetch_assoc()) {
                $projects[] = $row;
            }
            $stmt->close();
            return $projects;
        }

        public function getProjectById($project_id) {
            $query = "SELECT * FROM tblprojects WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $project_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $project = $result->fetch_assoc();
            $stmt->close();
            return $project;
        }

        public function deleteProject($project_id) {
            $query = "DELETE FROM tblprojects WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $project_id);
            $stmt->execute();
            $stmt->close();
        }

        public function addProject($customer_id, $project_description, $project_name, $project_cost, $project_downpayment, $project_file, $tdate, $status, $user_id) {
            $query = "INSERT INTO tblprojects (customer_id, project_description, project_name, project_cost, project_downpayment, project_file, tdate, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("issddssi", $customer_id, $project_description, $project_name, $project_cost, $project_downpayment, $project_file, $tdate, $status);
            $stmt->execute();
            $stmt->close();

            $balance = $project_cost - $project_downpayment;

            $project_id = $this->conn->insert_id;
            $query_payment = "INSERT INTO tblprojects_payment (project_id, credit, tdate, user_id) VALUES (?, ?, ?, ?)";
            $stmt_payment = $this->conn->prepare($query_payment);
            $stmt_payment->bind_param("idsi", $project_id, $balance, $tdate, $user_id);
            $stmt_payment->execute();
            $stmt_payment->close();
        }

        public function getProjectLoans($project_id) {
            $query = "SELECT * FROM tblprojects_payment WHERE tblprojects_payment.project_id = ? ORDER BY tblprojects_payment.id ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $project_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $loans = [];
            while ($row = $result->fetch_assoc()) {
                $loans[] = $row;
            }
            $stmt->close();
            return $loans;
        }

        public function getProjectLoanList()
        {
            $query = "SELECT *, tblprojects.id as project_id, tblprojects.tdate as tdate, tblprojects.project_name as project_name,
            (SELECT SUM(credit-debit) as total_balance FROM tblprojects_payment WHERE tblprojects_payment.project_id = tblprojects.id) as total_balance
             FROM tblprojects INNER JOIN tblcustomer ON tblprojects.customer_id = tblcustomer.id ORDER BY tblprojects.id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $loans = [];
            while ($row = $result->fetch_assoc()) {
                $loans[] = $row;
            }
            $stmt->close();
            return $loans;
        }

        public function getTotalBalance($project_id)
        {
            $query = "SELECT SUM(credit - debit) AS total_balance FROM tblprojects_payment WHERE project_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $project_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['total_balance'] ?? 0;
        }

        public function payLoan($project_id, $amount, $user_id) {
            $query = "INSERT INTO tblprojects_payment (project_id, debit, tdate, user_id) VALUES (?, ?, NOW(), ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("idi", $project_id, $amount, $user_id);
            $stmt->execute();
            $stmt->close();
        }

        public function getProjectProducts($project_id) {
            $query = "SELECT tp.*, tpt.quantity_out, tpt.price, tpt.voucher, tc.category_name
                      FROM tblproduct_transactions tpt
                      INNER JOIN tblproducts tp ON tpt.product_id = tp.id
                      INNER JOIN tblcategories tc ON tp.category_id = tc.id
                      WHERE tpt.project_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $project_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            $stmt->close();
            return $products;
        }
    }