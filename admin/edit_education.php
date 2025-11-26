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

$stmt = $pdo->prepare("SELECT * FROM education WHERE id=?");
$stmt->execute([$id]);
$edu = $stmt->fetch();
if (!$edu) die("Education not found.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school = trim($_POST['school']);
    $degree = trim($_POST['degree']);
    $start_year = intval($_POST['start_year']);
    $end_year = $_POST['end_year'] ? intval($_POST['end_year']) : null;
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);

    $update = $pdo->prepare("UPDATE education SET school=?, degree=?, start_year=?, end_year=?, location=?, description=? WHERE id=?");
    $update->execute([$school, $degree, $start_year, $end_year, $location, $description, $id]);

    echo "<p>Updated successfully. <a href='dashboard.php'>Back to Dashboard</a></p>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Education</title>
</head>
<body>
<h2>Edit Education</h2>

<form method="POST">
    <label>School:</label><br>
    <input type="text" name="school" value="<?= sanitize_input($edu['school']) ?>" required><br><br>

    <label>Degree:</label><br>
    <input type="text" name="degree" value="<?= sanitize_input($edu['degree']) ?>" required><br><br>

    <label>Start Year:</label><br>
    <input type="number" name="start_year" value="<?= sanitize_input($edu['start_year']) ?>" required><br><br>

    <label>End Year:</label><br>
    <input type="number" name="end_year" value="<?= sanitize_input($edu['end_year']) ?>"><br><br>

    <label>Location:</label><br>
    <input type="text" name="location" value="<?= sanitize_input($edu['location']) ?>"><br><br>

    <label>Description:</label><br>
    <textarea name="description"><?= sanitize_input($edu['description']) ?></textarea><br><br>

    <button type="submit">Update</button>
</form>

<p><a href="dashboard.php">Cancel</a></p>
</body>
</html>
