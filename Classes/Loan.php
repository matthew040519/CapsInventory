<?php

    require_once 'Notification.php';

    class Loan extends Notification {
        private $db;

        public function __construct($db) {
            parent::__construct($db);
            $this->db = $db;
        }

        public function getLoanDetails($loan_reference) {
            $stmt = $this->db->prepare("SELECT * FROM tblloans_details WHERE reference = ?");
            $stmt->bind_param("s", $loan_reference);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function getLoanByReference($loan_reference) {
            $stmt = $this->db->prepare("SELECT SUM(credit) - SUM(debit) AS balance, customer_id FROM tblloans_details WHERE reference = ? GROUP BY customer_id, reference");
            $stmt->bind_param("s", $loan_reference);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function addLoanPayment($reference, $transaction_ref, $customer_id, $debit, $user_id) {

           

            $stmt = $this->db->prepare("SELECT id FROM tblloans WHERE reference = ?");
            $stmt->bind_param("s", $reference);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $loan_id = $result ? $result['id'] : null;

            $stmt = $this->db->prepare("SELECT fullname FROM tblcustomer WHERE id = ?");
            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $customer_name = $result ? $result['fullname'] : '';

            $module = 'LoanPayment';
            // $link = "/admin/loan.php?id={$loan_id}";

            $link = "http://localhost/caps_inventory/admin/loan_details.php?id={$loan_id}&reference={$reference}";

            $this->addNotification("Loan payment of {$debit} added for customer {$customer_name}.", $user_id, $customer_id, date('Y-m-d H:i:s'), $module, $link);

            $stmt = $this->db->prepare("INSERT INTO tblloans_details (reference, transaction_ref, customer_id, debit, tdate) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("sssd", $reference, $transaction_ref, $customer_id, $debit);
            return $stmt->execute();
        }
    }