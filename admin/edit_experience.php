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

$stmt = $pdo->prepare("SELECT * FROM experience WHERE id=?");
$stmt->execute([$id]);
$exp = $stmt->fetch();
if (!$exp) die("Experience not found.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company = trim($_POST['company']);
    $position = trim($_POST['position']);
    $start_year = intval($_POST['start_year']);
    $end_year = $_POST['end_year'] ? intval($_POST['end_year']) : null;
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);

    $update = $pdo->prepare("UPDATE experience SET company=?, position=?, start_year=?, end_year=?, location=?, description=? WHERE id=?");
    $update->execute([$company, $position, $start_year, $end_year, $location, $description, $id]);

    echo "<p>Updated successfully. <a href='dashboard.php'>Back to Dashboard</a></p>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Experience</title>
</head>
<body>
<h2>Edit Experience</h2>

<form method="POST">
    <label>Company:</label><br>
    <input type="text" name="company" value="<?= sanitize_input($exp['company']) ?>" required><br><br>

    <label>Position:</label><br>
    <input type="text" name="position" value="<?= sanitize_input($exp['position']) ?>" required><br><br>

    <label>Start Year:</label><br>
    <input type="number" name="start_year" value="<?= sanitize_input($exp['start_year']) ?>" required><br><br>

    <label>End Year:</label><br>
    <input type="number" name="end_year" value="<?= sanitize_input($exp['end_year']) ?>"><br><br>

    <label>Location:</label><br>
    <input type="text" name="location" value="<?= sanitize_input($exp['location']) ?>"><br><br>

    <label>Description:</label><br>
    <textarea name="description"><?= sanitize_input($exp['description']) ?></textarea><br><br>

    <button type="submit">Update</button>
</form>

<p><a href="dashboard.php">Cancel</a></p>
</body>
</html>
