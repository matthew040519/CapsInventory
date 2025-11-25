<?php
// delete_product.php
require_once '../Classes/DB.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $db = new DB();
    $conn = $db->connect();

    $product_id = intval($_GET['id']);

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM tblproducts WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        // Redirect after successful deletion
        header("Location: product.php?msg=Product+deleted+successfully");
        exit();
    } else {
        echo "Error deleting product.";
    }

    $stmt->close();
} else {
    echo "Invalid product ID.";
}

$conn->close();
?>