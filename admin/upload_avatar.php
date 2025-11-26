<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];

    // Validation
    $allowedTypes = ['image/jpeg', 'image/png'];
    if (!in_array($file['type'], $allowedTypes)) {
        die("Only JPG and PNG images are allowed.");
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        die("File size must be less than 2MB.");
    }

    // Create uploads directory if not exists
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    // Generate unique filename
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = 'avatar_' . uniqid() . '.' . $ext;
    $uploadPath = $uploadDir . $newName;

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {

        // Create thumbnail using GD
        $thumbPath = $uploadDir . 'thumb_' . $newName;
        if ($ext === 'jpg' || $ext === 'jpeg') {
            $img = imagecreatefromjpeg($uploadPath);
        } else {
            $img = imagecreatefrompng($uploadPath);
        }

        $thumb = imagescale($img, 150, 150);
        if ($ext === 'jpg' || $ext === 'jpeg') {
            imagejpeg($thumb, $thumbPath);
        } else {
            imagepng($thumb, $thumbPath);
        }
        imagedestroy($img);
        imagedestroy($thumb);

        // Update database
        $stmt = $pdo->prepare("UPDATE resume SET avatar_path=? WHERE id=?");
        $stmt->execute([$thumbPath, 1]); // assuming resume id=1

        echo "Profile picture uploaded successfully. <a href='dashboard.php'>Back to Dashboard</a>";
    } else {
        echo "Upload failed.";
    }
}
?>
