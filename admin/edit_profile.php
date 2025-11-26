<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch existing resume if any
$stmt = $pdo->query("SELECT * FROM resume LIMIT 1");
$resume = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name   = trim($_POST['full_name']);
    $title       = trim($_POST['title']);
    $about       = trim($_POST['about']);
    $email       = trim($_POST['email']);
    $phone       = trim($_POST['phone']);
    $location    = trim($_POST['location']);
    $linkedin    = trim($_POST['linkedin']);
    $github      = trim($_POST['github']);
    $avatar_path = trim($_POST['avatar_path']);

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

<form method="POST">
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

    <label>Avatar Path:</label><br>
    <input type="text" name="avatar_path" value="<?= sanitize_input($resume['avatar_path'] ?? '') ?>"><br><br>

    <button type="submit"><?= $resume ? 'Update' : 'Create' ?></button>
</form>

<p><a href="dashboard.php">Cancel</a></p>

</body>
</html>
