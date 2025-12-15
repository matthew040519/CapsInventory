<?php 


    require_once '../Classes/DB.php';
    require_once '../Classes/Projects.php';

    $database = new DB();
    $dbConnection = $database->connect();
    $projects = new Projects($dbConnection);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['transaction_id'])) {
            $transaction_id = intval($_POST['transaction_id']);

            // Delete the product transaction
            $query = "DELETE FROM tblproduct_transactions WHERE id = ?";
            $stmt = $dbConnection->prepare($query);
            $stmt->bind_param("i", $transaction_id);
            $stmt->execute();
            $stmt->close();

            // Redirect back to the project details page
            header("Location: projects.php");
            exit();
        } else {
            // Invalid request
            header("Location: projects.php");
            exit();
        }
    } else {
        // Invalid request method
        header("Location: projects.php");
        exit();
    }