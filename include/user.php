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
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        if ($count > 0) {
            $error = "Username must be unique.";
            header('Location: ../admin/users.php?error=' . urlencode($error));
            exit();
        }
        $stmt->close();
        $password = $_POST['password'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $profile_picture = $_FILES['profile_picture'];
            // Handle file upload

        $targetDir = "../uploads/profile_pictures/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileName = basename($profile_picture["name"]);
        $targetFilePath = $targetDir . $fileName;
        move_uploaded_file($profile_picture["tmp_name"], $targetFilePath);

        $user = new Users($conn);
        if ($user->createUser($username, $password, $email, $role, $targetFilePath)) {
            header('Location: ../admin/users.php?success=User added successfully');
            exit();
        } else {
            $error = "Error adding user.";
            header('Location: ../admin/users.php?error=' . urlencode($error));
            exit();
        }

    }