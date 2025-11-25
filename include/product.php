<?php 


   require_once '../Classes/DB.php';
   require_once '../Classes/Product.php';

   if($_SERVER["REQUEST_METHOD"] == "POST") {

        if($_POST['action'] === 'edit') {
            $db = new DB();
            $conn = $db->connect();

            $id = $_POST['product_id'];
            $name = $_POST['product_name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $re_order_point = $_POST['re_order_point'];
            $image = $_FILES['product_image']['name'];

            $product = new Product($conn);
            if ($product->updateProduct($id, $name, $description, $price, $category_id, $re_order_point, $image)) {
                if ($image) {
                    move_uploaded_file($_FILES['product_image']['tmp_name'], '../uploads/products/' . $image);
                }
                header('Location: ../admin/product.php?success=Product updated successfully');
                exit();
            } else {
                $error = "Error updating product.";
                header('Location: ../admin/product.php?error=' . urlencode($error));
                exit();
            }
        }

        

        $db = new DB();
        $conn = $db->connect();

        // echo $_POST['description'];

        $image = $_FILES['product_image']['name'];
        $name = $_POST['product_name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        $re_order_point = $_POST['re_order_point'];

        $product = new Product($conn);
        if ($product->createProduct($image, $name, $description, $price, $category_id, $re_order_point)) {
            move_uploaded_file($_FILES['product_image']['tmp_name'], '../uploads/products/' . $image);
            header('Location: ../admin/product.php?success=Product added successfully');
            exit();
        } else {
            $error = "Error adding product.";
            header('Location: ../admin/product.php?error=' . urlencode($error));
            exit();
        }

    }