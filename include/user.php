<?php

    require_once '../Classes/DB.php';
    require_once '../Classes/Users.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $db = new DB();
        $conn = $db->connect();

        if($_POST['action'] === 'edit') {
            $id = $_POST['user_id'];
            $username = $_POST['username'];
            $email = $_POST['email'];

            $user = new Users($conn);
            if ($user->updateUser($id, $username, $email)) {
                header('Location: ../admin/users.php?success=User updated successfully');
                exit();
            } else {
                $error = "Error updating user.";
                header('Location: ../admin/users.php?error=' . urlencode($error));
                exit();
            }
        }

        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $user = new Users($conn);
        if ($user->createUser($username, $password, $email, $role)) {
            header('Location: ../admin/users.php?success=User added successfully');
            exit();
        } else {
            $error = "Error adding user.";
            header('Location: ../admin/users.php?error=' . urlencode($error));
            exit();
        }

    }