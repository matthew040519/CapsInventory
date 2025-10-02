<?php 


if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    require_once '../../Classes/DB.php';
    require_once '../../Classes/Auth.php';

    $db = new DB();
    $conn = $db->connect();

    // Get username and password from POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    $auth = new Login($username, $password, $conn);
    if ($auth->login()) {
        header('Location: ../../admin/dashboard.php');
        exit();
    } else {
        $error = "Invalid username or password.";
        header('Location: ../../index.php?error=' . urlencode($error));
        exit();
    }
}