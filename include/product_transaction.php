<?php 

    require_once '../Classes/DB.php';
    require_once '../Classes/ProductTransaction.php';
    require_once '../Classes/Product.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $db = new DB();
        $conn = $db->connect();
        session_start();

        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $date = $_POST['date'];
        $voucher = $_POST['voucher'];
        $supplier_id = $_POST['supplier_id'];
        $user_id = $_SESSION['user_id'];
        // $description = $_POST['description'];
        $price = 0; // Default price to 0 if not provided

        $product = new Product($conn);
        $productDetails = $product->getProductById($product_id);
        if ($productDetails) {
            $price = $productDetails['price'];
        }

        $productTransaction = new ProductTransaction($conn);
        if ($productTransaction->addTransaction($voucher, $product_id, $quantity, $date, $price, $supplier_id, $user_id)) {
            header('Location: ../admin/quantity-management.php?success=Quantity added successfully');
            exit();
        } else {
            $error = "Error adding quantity.";
            header('Location: ../admin/quantity-management.php?error=' . urlencode($error));
            exit();
        }

    }