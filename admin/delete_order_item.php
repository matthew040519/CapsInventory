<?php 


    $order_id = $_GET['order_id'];
    $item_id = $_GET['item_id'];

    require_once '../Classes/DB.php';
    require_once '../Classes/ProductTransaction.php';

    $db = new DB();
    $conn = $db->connect();

    $productTransaction = new ProductTransaction($conn);
    if ($productTransaction->deleteTransaction($item_id)) {
        header("Location: order_view.php?id=$order_id&msg=Item+deleted+successfully");
        exit();
    } else {
        echo "Error deleting record.";
    }

    $stmt->close();
    $conn->close();