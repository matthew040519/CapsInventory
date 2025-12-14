<?php 


require_once '../Classes/DB.php';
require_once '../Classes/Projects.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new DB();
    $conn = $db->connect();

    $project_id = $_POST['project_id'];

    $projects = new Projects($conn);
    if ($projects->deleteProject($project_id)) {
        header('Location: ../admin/projects.php?success=Project deleted successfully');
        exit();
    } else {
        $error = "Error deleting project.";
        header('Location: ../admin/projects.php?error=' . urlencode($error));
        exit();
    }

}