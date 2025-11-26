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

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id=?");
$stmt->execute([$id]);
$proj = $stmt->fetch();
if (!$proj) die("Project not found.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $link = trim($_POST['link']);
    $start_year = $_POST['start_year'] ? intval($_POST['start_year']) : null;
    $end_year = $_POST['end_year'] ? intval($_POST['end_year']) : null;

    $update = $pdo->prepare("UPDATE projects SET title=?, description=?, link=?, start_year=?, end_year=? WHERE id=?");
    $update->execute([$title, $description, $link, $start_year, $end_year, $id]);

    echo "<p>Updated successfully. <a href='dashboard.php'>Back to Dashboard</a></p>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Project</title>
</head>
<body>
<h2>Edit Project</h2>

<form method="POST">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?= sanitize_input($proj['title']) ?>" required><br><br>

    <label>Description:</label><br>
    <textarea name="description"><?= sanitize_input($proj['description']) ?></textarea><br><br>

    <label>Link:</label><br>
    <input type="text" name="link" value="<?= sanitize_input($proj['link']) ?>"><br><br>

    <label>Start Year:</label><br>
    <input type="number" name="start_year" value="<?= sanitize_input($proj['start_year']) ?>"><br><br>

    <label>End Year:</label><br>
    <input type="number" name="end_year" value="<?= sanitize_input($proj['end_year']) ?>"><br><br>

    <button type="submit">Update</button>
</form>

<p><a href="dashboard.php">Cancel</a></p>
</body>
</html>
