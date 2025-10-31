<?php


    class Loan {
        private $db;

        public function __construct($db) {
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

        public function addLoanPayment($reference, $transaction_ref, $customer_id, $debit) {
            $stmt = $this->db->prepare("INSERT INTO tblloans_details (reference, transaction_ref, customer_id, debit, tdate) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("sssd", $reference, $transaction_ref, $customer_id, $debit);
            return $stmt->execute();
        }
    }