<?php


require_once '../Classes/DB.php';
require_once '../Classes/Order.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['order_id'])) {

    $db = new DB();
    $conn = $db->connect();
    session_start();

    $order_id = $_GET['order_id'];
    $user_id = $_SESSION['user_id'];

    // Check for voucher in tblproduct_transactions for the given order_id
    $query = "SELECT voucher, quantity_out, price, customer_id FROM tblproduct_transactions WHERE cart_id = ? AND voucher = 'LS'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $voucherExists = false;
    $customer_id = null;
    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $customer_id = $row['customer_id'];
        $total += ($row['quantity_out'] * $row['price']);
    }

    $stmt->close();

    $randomCode = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);

    if ($total > 0) {
        // Insert into tblloans
        $reference = $randomCode;
        $loanQuery = "INSERT INTO tblloans (reference, order_id, customer_id, tdate) VALUES (?, ?, ?, NOW())";
        $loanStmt = $conn->prepare($loanQuery);
        $loanStmt->bind_param("sii", $reference, $order_id, $customer_id);
        $loanStmt->execute();
        $loanStmt->close();

        $loanDetails = "INSERT INTO tblloans_details (reference, transaction_ref, customer_id, credit, tdate) VALUES (?, ?, ?, ?, NOW())";
        $loanDetailsStmt = $conn->prepare($loanDetails);
        $loanDetailsStmt->bind_param("ssid", $reference, $reference, $customer_id, $total);
        $loanDetailsStmt->execute();
    }

    // You can use $voucherExists for further logic if needed

    $order = new Order($conn);
    if ($order->checkoutOrder($order_id, $user_id)) {
        echo "<script>window.open('../admin/invoice.php?order_id={$order_id}', '_blank'); window.location.href = '../admin/orders.php';</script>";
        exit();
    } else {
        $error = "Error checking out order.";
        header('Location: ../admin/orders.php?error=' . urlencode($error));
        exit();
    }

} else {
    header('Location: ../admin/orders.php?error=' . urlencode("Invalid request."));
    exit();
}