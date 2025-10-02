<?php


    require_once '../Classes/DB.php';
    require_once '../Classes/ProductTransaction.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $db = new DB();
        $conn = $db->connect();

        session_start();

        $voucher = $_POST['voucher'];
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $date = $_POST['date'];
        $discount = $_POST['discount'];
        $price = $_POST['price'];
        $customer_id = $_POST['customer_id'];
        $user_id = $_SESSION['user_id'];

        $productTransaction = new ProductTransaction($conn);
        if ($productTransaction->sellProduct($voucher, $product_id, $quantity, $date, $discount, $price, $customer_id, $user_id)) {
            header('Location: ../admin/buyproducts.php?success=Product added successfully');
            exit();
        } else {
            $error = "Error adding product.";
            header('Location: ../admin/buyproducts.php?error=' . urlencode($error));
            exit();
        }

    }