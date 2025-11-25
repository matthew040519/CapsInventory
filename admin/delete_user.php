<?php
// delete_product.php
require_once '../Classes/DB.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $db = new DB();
    $conn = $db->connect();

    $user_id = intval($_GET['id']);

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Redirect after successful deletion
        header("Location: users.php?msg=User+deleted+successfully");
        exit();
    } else {
        echo "Error deleting user.";
    }

    $stmt->close();
} else {
    echo "Invalid user ID.";
}

$conn->close();
?>