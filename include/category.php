<?php


    require_once '../Classes/DB.php';
    require_once '../Classes/Category.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $db = new DB();
        $conn = $db->connect();

        $categoryName = $_POST['category_name'];

        $category = new Category($conn);
        if ($category->createCategory($categoryName)) {
            header('Location: ../admin/category.php?success=Category added successfully');
            exit();
        } else {
            $error = "Error adding category.";
            header('Location: ../admin/category.php?error=' . urlencode($error));
            exit();
        }

    }