<?php 

    // include('Notification.php');
    require_once 'Notification.php';

    class Order extends Notification{
        private $db;

        public function __construct($db) {
            parent::__construct($db);
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

            $message = "Order #{$order_id} has been checked out.";

            $stmt = $this->db->prepare("SELECT customer_id FROM tblcart WHERE id = ?");
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $customer = $result->fetch_assoc();
            $customer_id = $customer ? $customer['customer_id'] : null;

            $link = "http://localhost/caps_inventory/admin/invoice.php?order_id=$order_id";

            $this->addNotification($message, $user_id, $customer_id, date('Y-m-d H:i:s'), 'Checkout', $link);

            $status_id = 4; // Assuming '4' is the ID for 'Completed' status
            $stmt = $this->db->prepare("UPDATE tblcart SET status_id = ?, user_id = ? WHERE id = ?");
            $stmt->bind_param("iii", $status_id, $user_id, $order_id);
            return $stmt->execute();
        }

        public function loanCheckoutOrder()
        {
            $stmt = $this->db->prepare("SELECT tblcustomer.fullname, tblloans.tdate, tblloans.id, tblloans.reference,
            (SELECT SUM(credit) - SUM(debit) AS totalAmount from tblloans_details WHERE tblloans_details.reference=tblloans.reference) AS totalAmount
            FROM tblloans INNER JOIN tblcustomer ON tblcustomer.id=tblloans.customer_id
            HAVING totalAmount > 0");
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function loanCheckoutOrderReturnALl()
        {
            $stmt = $this->db->prepare("SELECT tblloans.id as LoanId, tblcustomer.fullname, tblloans.tdate, tblloans.id, tblloans.reference,
            (SELECT SUM(credit) - SUM(debit) AS totalAmount from tblloans_details WHERE tblloans_details.reference=tblloans.reference) AS totalAmount
            FROM tblloans INNER JOIN tblcustomer ON tblcustomer.id=tblloans.customer_id");
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
    }