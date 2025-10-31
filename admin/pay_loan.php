<?php 


    
    require_once '../Classes/DB.php';
    require_once '../Classes/Loan.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $db = new DB();
        $conn = $db->connect();

        $randomCode = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);

        $reference = $_POST['reference'];
        $transaction_ref = $randomCode;
        $customer_id = $_POST['customer_id'];
        $debit = $_POST['amount'];

        $loan = new Loan($conn);
        if ($loan->addLoanPayment($reference, $transaction_ref, $customer_id, $debit)) {
            header('Location: ../admin/loan_details.php?reference=' . urlencode($reference) . '&success=Payment added successfully');
            exit();
        } else {
            $error = "Error adding payment.";
            header('Location: ../admin/loan_details.php?reference=' . urlencode($reference) . '&error=' . urlencode($error));
            exit();
        }

    }
