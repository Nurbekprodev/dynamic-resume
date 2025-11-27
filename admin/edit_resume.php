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

$errors = [];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name   = trim($_POST['full_name']);
    $title       = trim($_POST['title']);
    $about       = trim($_POST['about']);
    $email       = trim($_POST['email']);
    $phone       = trim($_POST['phone']);
    $location    = trim($_POST['location']);
    $linkedin    = trim($_POST['linkedin']);
    $github      = trim($_POST['github']);
    $avatar_path = $resume['avatar_path'] ?? null;

    if ($full_name === '') $errors[] = "Full Name is required.";

    // Handle avatar upload
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $file = $_FILES['avatar'];
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($file['type'], $allowedTypes)) $errors[] = "Only JPG and PNG images are allowed.";
        if ($file['size'] > 2 * 1024 * 1024) $errors[] = "File size must be less than 2MB.";

        if (empty($errors)) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newName = 'avatar_' . uniqid() . '.' . $ext;
            $uploadPath = $uploadDir . $newName;

            if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $errors[] = "Failed to upload file.";
            } else {
                $thumbPath = $uploadDir . 'thumb_' . $newName;
                $img = ($ext === 'jpg' || $ext === 'jpeg') ? imagecreatefromjpeg($uploadPath) : imagecreatefrompng($uploadPath);
                $thumb = imagescale($img, 150, 150);
                ($ext === 'jpg' || $ext === 'jpeg') ? imagejpeg($thumb, $thumbPath) : imagepng($thumb, $thumbPath);
                imagedestroy($img);
                imagedestroy($thumb);
                $avatar_path = $thumbPath;
            }
        }
    }

    if (empty($errors)) {
        if ($resume) {
            $update = $pdo->prepare("
                UPDATE resume 
                SET full_name=?, title=?, about=?, email=?, phone=?, location=?, linkedin=?, github=?, avatar_path=? 
                WHERE id=?
            ");
            $update->execute([
                $full_name, $title, $about, $email, $phone,
                $location, $linkedin, $github, $avatar_path,
                $resume['id']
            ]);
            $message = "Resume updated successfully.";
        } else {
            $insert = $pdo->prepare("
                INSERT INTO resume (full_name, title, about, email, phone, location, linkedin, github, avatar_path) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $insert->execute([
                $full_name, $title, $about, $email, $phone,
                $location, $linkedin, $github, $avatar_path
            ]);
            $message = "Resume created successfully.";
        }
        header("Location: dashboard.php?success=resume_saved");
        exit;
    }
}

include '../includes/header.php';
?>

<div class="page-container">

    <div class="page-header">
        <h2><?= $resume ? 'Edit' : 'Create' ?> Resume</h2>
        <a class="btn-back" href="dashboard.php">← Back to Dashboard</a>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $err): ?>
                <p><?= $err ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="form-box">

        <label>Full Name:</label>
        <input type="text" name="full_name" value="<?= sanitize_input($resume['full_name'] ?? '') ?>" required>

        <label>Title:</label>
        <input type="text" name="title" value="<?= sanitize_input($resume['title'] ?? '') ?>">

        <label>About:</label>
        <textarea name="about"><?= sanitize_input($resume['about'] ?? '') ?></textarea>

        <label>Email:</label>
        <input type="text" name="email" value="<?= sanitize_input($resume['email'] ?? '') ?>">

        <label>Phone:</label>
        <input type="text" name="phone" value="<?= sanitize_input($resume['phone'] ?? '') ?>">

        <label>Location:</label>
        <input type="text" name="location" value="<?= sanitize_input($resume['location'] ?? '') ?>">

        <label>LinkedIn:</label>
        <input type="text" name="linkedin" value="<?= sanitize_input($resume['linkedin'] ?? '') ?>">

        <label>GitHub:</label>
        <input type="text" name="github" value="<?= sanitize_input($resume['github'] ?? '') ?>">

        <label>Profile Picture:</label>
        <input type="file" name="avatar" accept="image/png, image/jpeg">
        <?php if (!empty($resume['avatar_path'])): ?>
            <img src="<?= htmlspecialchars($resume['avatar_path']) ?>" alt="Avatar" style="margin-top:5px; width:80px; height:80px;">
        <?php endif; ?>

        <button type="submit" class="btn-primary"><?= $resume ? 'Update' : 'Create' ?></button>
    </form>

</div>

<?php include '../includes/footer.php'; ?>
