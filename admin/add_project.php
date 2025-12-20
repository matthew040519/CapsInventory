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
        $user_id = $_SESSION['user_id'];

        // echo $status;

        // Check if downpayment is higher than project cost
        if (floatval($downpayment) > floatval($project_cost)) {
            header('Location: ../admin/projects.php?error=Downpayment cannot be higher than project cost');
            exit();
        }

        $projects = new Projects($conn);
        

        if ($project_file) {
            $timestamp = time();
            $file_ext = pathinfo($project_file, PATHINFO_EXTENSION);
            $new_file_name = pathinfo($project_file, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $file_ext;
            move_uploaded_file($_FILES['project_file']['tmp_name'], '../uploads/projects/' . $new_file_name);
            $projects->addProject($customer_id, $project_description, $project_name, $project_cost, $downpayment, $new_file_name, $tdate, $status, $user_id);
        }

        header('Location: ../admin/projects.php?success=Project added successfully');
        exit();
    }