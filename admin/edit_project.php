<?php

    require_once '../Classes/DB.php';
    require_once '../Classes/Projects.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $db = new DB();
        $conn = $db->connect();

        session_start();

        $customer_id = $_POST['customer_id'];
        $project_name = $_POST['project_name'];
        $project_cost = $_POST['project_cost'];
        $project_file = $_FILES['project_file']['name'];
        $tdate = $_POST['tdate'];
        $status = $_POST['status'];
        $project_description = $_POST['project_description'];
        $downpayment = $_POST['downpayment'];
        $project_id = (int)$_POST['id'];

        if (!is_numeric($project_cost) || $project_cost < 0) {
            echo "Invalid project cost.";
            exit();
        }

        if (!is_numeric($downpayment) || $downpayment < 0) {
            echo "Invalid downpayment.";
            exit();
        }

        if ($downpayment > $project_cost) {
            echo "Downpayment cannot be greater than project cost.";
            exit();
        }

        // Prepare the SQL statement to update the project
        $sql = "UPDATE tblprojects SET 
                customer_id = ?, 
                project_name = ?, 
                project_cost = ?, 
                tdate = ?, 
                status = ?, 
                project_description = ?, 
                project_downpayment = ?
            WHERE id = ?";

        // Get the project_id from POST (make sure your form sends it)
        

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "isdsssdi",
            $customer_id,
            $project_name,
            $project_cost,
            $tdate,
            $status,
            $project_description,
            $downpayment,
            $project_id
        );

        // Handle file upload if a new file is provided
        if (!empty($_FILES['project_file']['name'])) {
            $targetDir = "../uploads/projects/";
            if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
            }
            $targetFile = $targetDir . basename($_FILES['project_file']['name']);
            if (!move_uploaded_file($_FILES['project_file']['tmp_name'], $targetFile)) {
            echo "Error uploading file.";
            exit();
            }

            // Update the project_file field in the database
            $sql_file = "UPDATE tblprojects SET project_file = ? WHERE project_id = ?";
            $stmt_file = $conn->prepare($sql_file);
            $stmt_file->bind_param("si", $project_file, $project_id);
            $stmt_file->execute();
            $stmt_file->close();
        }

        // Check if downpayment has changed and update tblprojects_payments if needed
        // Fetch the current downpayment from tblprojects
        $sql_current = "SELECT project_downpayment FROM tblprojects WHERE id = ?";
        $stmt_current = $conn->prepare($sql_current);
        $stmt_current->bind_param("i", $project_id);
        $stmt_current->execute();
        $stmt_current->bind_result($current_downpayment);
        $stmt_current->fetch();
        $stmt_current->close();

        if ($downpayment != $current_downpayment) {
            $balance = $project_cost - $downpayment;
            // Update the first payment row for this project
            $sql_payment = "UPDATE tblprojects_payment SET credit = ? WHERE project_id = ? ORDER BY id ASC LIMIT 1";
            $stmt_payment = $conn->prepare($sql_payment);
            $stmt_payment->bind_param("di", $balance, $project_id);
            $stmt_payment->execute();
            $stmt_payment->close();
        }

        if ($stmt->execute()) {
            // Success, redirect or show a message
            header("Location: projects.php?msg=Project updated successfully");
            exit();
        } else {
            echo "Error updating project: " . $stmt->error;
        }
        $stmt->close();
        $conn->close();
    }