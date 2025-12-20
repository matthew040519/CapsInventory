<?php 

    session_start();
    require_once '../../Classes/DB.php';

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {

        $db = new DB();
        $conn = $db->connect();

        $file = $_FILES['profile_picture'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB

        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => 'File upload error.']);
            exit;
        }

        if (!in_array($file['type'], $allowed_types)) {
            echo json_encode(['error' => 'Invalid file type.']);
            exit;
        }

        if ($file['size'] > $max_size) {
            echo json_encode(['error' => 'File too large.']);
            exit;
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = 'profile_' . $user_id . '_' . time() . '.' . $ext;
        $upload_dir = '../../uploads/profile_pictures/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $upload_path = $upload_dir . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            // Update database
            $stmt = $conn->prepare("UPDATE users SET image = ? WHERE id = ?");
            $profile_picture_path = '../uploads/profile_pictures/' . $new_filename;
            $stmt->bind_param('si', $profile_picture_path, $user_id);
            if ($stmt->execute()) {
                // echo json_encode(['success' => true, 'profile_picture' => $profile_picture_path]);
                // header('Location: ../../admin/dashboard.php?success=Profile picture updated successfully');
                header('Location: ../../include/auth/logout.php');
                exit;
            } else {
                echo json_encode(['error' => 'Database update failed.']);
            }
            $stmt->close();
        } else {
            echo json_encode(['error' => 'Failed to move uploaded file.']);
        }
    } else {
        echo json_encode(['error' => 'No file uploaded.']);
    }