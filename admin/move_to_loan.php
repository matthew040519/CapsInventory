<?php 


    $order_id = $_GET['order_id'];
    $item_id = $_GET['item_id'];
    $voucher = $_GET['voucher'];

    require_once '../Classes/DB.php';
    require_once '../Classes/ProductTransaction.php';

    $db = new DB();
    $conn = $db->connect();

    $productTransaction = new ProductTransaction($conn);
    if ($productTransaction->moveToLoan($item_id, $voucher)) {
        header("Location: order_view.php?id=$order_id&msg=Item+moved+to+loan+successfully");
        exit();
    } else {
        echo "Error moving record to loan.";
    }

    $stmt->close();
    $conn->close();