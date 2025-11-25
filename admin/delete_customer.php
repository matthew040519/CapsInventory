<?php
// delete_customer.php

require_once '../Classes/DB.php';

if (isset($_GET['id'])) {
    $customer_id = intval($_GET['id']);

    $db = new DB();
    $conn = $db->connect();

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM tblcustomer WHERE id = ?");
    $stmt->bind_param("i", $customer_id);

    if ($stmt->execute()) {
        header("Location: customer.php?success=Customer+deleted+successfully");
        exit();
    } else {
        echo "Error deleting customer.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>