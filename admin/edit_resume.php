<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch existing resume if any
$stmt = $pdo->query("SELECT * FROM resume LIMIT 1");
$resume = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $title     = trim($_POST['title']);
    $about     = trim($_POST['about']);
    $email     = trim($_POST['email']);
    $phone     = trim($_POST['phone']);
    $location  = trim($_POST['location']);
    $linkedin  = trim($_POST['linkedin']);
    $github    = trim($_POST['github']);
    $avatar_path = $resume['avatar_path'] ?? null; // default to existing

    // Handle file upload
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $file = $_FILES['avatar'];

        // Validate type & size
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($file['type'], $allowedTypes)) {
            die("Only JPG and PNG images are allowed.");
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            die("File size must be less than 2MB.");
        }

        // Upload directory
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        // Unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = 'avatar_' . uniqid() . '.' . $ext;
        $uploadPath = $uploadDir . $newName;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            die("Failed to upload file.");
        }

        // Create thumbnail 150x150
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

        // Use thumbnail path for DB
        $avatar_path = $thumbPath;
    }

    if ($resume) {
        // Update existing resume
        $update = $pdo->prepare("UPDATE resume SET full_name=?, title=?, about=?, email=?, phone=?, location=?, linkedin=?, github=?, avatar_path=? WHERE id=?");
        $update->execute([
            $full_name, $title, $about, $email, $phone,
            $location, $linkedin, $github, $avatar_path,
            $resume['id']
        ]);
        $message = "Resume updated successfully.";
    } else {
        // Insert new resume
        $insert = $pdo->prepare("INSERT INTO resume (full_name, title, about, email, phone, location, linkedin, github, avatar_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->execute([
            $full_name, $title, $about, $email, $phone,
            $location, $linkedin, $github, $avatar_path
        ]);
        $message = "Resume created successfully.";
    }

    echo "<p>$message <a href='dashboard.php'>Back to Dashboard</a></p>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $resume ? 'Edit' : 'Create' ?> Resume</title>
</head>
<body>
<h2><?= $resume ? 'Edit' : 'Create' ?> Resume</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Full Name:</label><br>
    <input type="text" name="full_name" value="<?= sanitize_input($resume['full_name'] ?? '') ?>" required><br><br>

    <label>Title:</label><br>
    <input type="text" name="title" value="<?= sanitize_input($resume['title'] ?? '') ?>"><br><br>

    <label>About:</label><br>
    <textarea name="about"><?= sanitize_input($resume['about'] ?? '') ?></textarea><br><br>

    <label>Email:</label><br>
    <input type="text" name="email" value="<?= sanitize_input($resume['email'] ?? '') ?>"><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" value="<?= sanitize_input($resume['phone'] ?? '') ?>"><br><br>

    <label>Location:</label><br>
    <input type="text" name="location" value="<?= sanitize_input($resume['location'] ?? '') ?>"><br><br>

    <label>LinkedIn:</label><br>
    <input type="text" name="linkedin" value="<?= sanitize_input($resume['linkedin'] ?? '') ?>"><br><br>

    <label>GitHub:</label><br>
    <input type="text" name="github" value="<?= sanitize_input($resume['github'] ?? '') ?>"><br><br>

    <label>Profile Picture:</label><br>
    <input type="file" name="avatar" accept="image/png, image/jpeg"><br>
    <?php if (!empty($resume['avatar_path'])): ?>
        <img src="<?= htmlspecialchars($resume['avatar_path']) ?>" alt="Avatar" style="margin-top:5px; width:80px; height:80px;">
    <?php endif; ?>
    <br><br>

    <button type="submit"><?= $resume ? 'Update' : 'Create' ?></button>
</form>

<p><a href="dashboard.php">Cancel</a></p>
</body>
</html>
