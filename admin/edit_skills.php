<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Invalid ID.");
$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM skills WHERE id=?");
$stmt->execute([$id]);
$skill = $stmt->fetch();
if (!$skill) die("Skill not found.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skill_name = trim($_POST['skill_name']);
    $level = trim($_POST['level']);
    $category = trim($_POST['category']);

    $update = $pdo->prepare("UPDATE skills SET skill_name=?, level=?, category=? WHERE id=?");
    $update->execute([$skill_name, $level, $category, $id]);

    echo "<p>Updated successfully. <a href='dashboard.php'>Back to Dashboard</a></p>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Skill</title>
</head>
<body>
<h2>Edit Skill</h2>

<form method="POST">
    <label>Skill Name:</label><br>
    <input type="text" name="skill_name" value="<?= sanitize_input($skill['skill_name']) ?>" required><br><br>

    <label>Level:</label><br>
    <input type="text" name="level" value="<?= sanitize_input($skill['level']) ?>"><br><br>

    <label>Category:</label><br>
    <input type="text" name="category" value="<?= sanitize_input($skill['category']) ?>"><br><br>

    <button type="submit">Update</button>
</form>

<p><a href="dashboard.php">Cancel</a></p>
</body>
</html>
