<?php 


require_once '../Classes/DB.php';
   require_once '../Classes/Supplier.php';

   if($_SERVER["REQUEST_METHOD"] == "POST") {

        $db = new DB();
        $conn = $db->connect();

        // echo $_POST['description'];
        $supplier_name = $_POST['supplier_name'];
        $supplier_address = $_POST['supplier_address'];

        $supplier = new Supplier($conn);
        if ($supplier->createSupplier($supplier_name, $supplier_address)) {
            header('Location: ../admin/supplier.php?success=Supplier added successfully');
            exit();
        } else {
            $error = "Error adding supplier.";
            header('Location: ../admin/supplier.php?error=' . urlencode($error));
            exit();
        }

    }