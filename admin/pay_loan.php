<?php 


    
    require_once '../Classes/DB.php';
    require_once '../Classes/Projects.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        // $db = new DB();
        // $conn = $db->connect();

        // $randomCode = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);

        // $reference = $_POST['reference'];
        // $transaction_ref = $randomCode;
        // $customer_id = $_POST['customer_id'];
        // $debit = $_POST['amount'];
        //     session_start();
        //     $user_id = $_SESSION['user_id'];

        // $loan = new Loan($conn);
        // if ($loan->addLoanPayment($reference, $transaction_ref, $customer_id, $debit, $user_id)) {
        //     header('Location: ../admin/loan_details.php?reference=' . urlencode($reference) . '&success=Payment added successfully');
        //     exit();
        // } else {
        //     $error = "Error adding payment.";
        //     header('Location: ../admin/loan_details.php?reference=' . urlencode($reference) . '&error=' . urlencode($error));
        //     exit();
        // }
        $db = new DB();
        $conn = $db->connect();

        $amount_to_pay = $_POST['amount_to_pay'];
        $total_balance = $_POST['total_balance'];
        $project_id = $_POST['project_id'];
            session_start();
            $user_id = $_SESSION['user_id'];


        $projects = new Projects($conn);
        if ($projects->payLoan($project_id, $amount_to_pay, $user_id)) {
            header('Location: ../admin/loan_details.php?id=' . urlencode($project_id) . '&success=Payment added successfully');
            exit();
        } else {
            $error = "Error adding payment.";
            header('Location: ../admin/loan_details.php?id=' . urlencode($project_id) . '&error=' . urlencode($error));
            exit();
        }

    }
