<?php 


require_once '../Classes/DB.php';
   require_once '../Classes/Customer.php';

   if($_SERVER["REQUEST_METHOD"] == "POST") {

        $db = new DB();
        $conn = $db->connect();

        // echo $_POST['description'];
        $fullname = $_POST['fullname'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        $contact_number = $_POST['contact_number'];

        $customer = new Customer($conn);
        if ($customer->createCustomer($fullname, $address, $contact_number, $gender)) {
            header('Location: ../admin/customer.php?success=Customer added successfully');
            exit();
        } else {
            $error = "Error adding customer.";
            header('Location: ../admin/customer.php?error=' . urlencode($error));
            exit();
        }

    }