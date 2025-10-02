<?php


require_once '../Classes/DB.php';
require_once '../Classes/Order.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['order_id'])) {

    $db = new DB();
    $conn = $db->connect();
    session_start();

    $order_id = $_GET['order_id'];
    $user_id = $_SESSION['user_id'];

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