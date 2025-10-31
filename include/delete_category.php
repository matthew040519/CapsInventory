<?php

    if (isset($_GET['id'])) {
        $category_id = $_GET['id'];

        require_once '../Classes/DB.php';
        require_once '../Classes/Category.php';

        $db = new DB();
        $conn = $db->connect();

        $category = new Category($conn);
        if ($category->deleteCategory($category_id)) {
            header("Location: ../admin/category.php?msg=Category+deleted+successfully");
            exit();
        } else {
            echo "Error deleting category.";
        }

        $conn->close();
    } else {
        echo "No category ID provided.";
    }