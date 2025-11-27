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

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school      = trim($_POST['school']);
    $degree      = trim($_POST['degree']);
    $start_year  = intval($_POST['start_year']);
    $end_year    = $_POST['end_year'] ? intval($_POST['end_year']) : null;
    $location    = trim($_POST['location']);
    $description = trim($_POST['description']);

    if ($school === '') $errors[] = "School name is required.";
    if ($degree === '') $errors[] = "Degree is required.";
    if ($start_year <= 0) $errors[] = "Start year is required.";

    if (empty($errors)) {
        $update = $pdo->prepare("
            UPDATE education 
            SET school=?, degree=?, start_year=?, end_year=?, location=?, description=? 
            WHERE id=?
        ");
        $update->execute([$school, $degree, $start_year, $end_year, $location, $description, $id]);

        header("Location: dashboard.php?success=education_updated");
        exit;
    }
}

include '../includes/header.php';
?>

<div class="page-container">

    <div class="page-header">
        <h2>Edit Education</h2>
        <a class="btn-back" href="dashboard.php">← Back to Dashboard</a>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $err): ?>
                <p><?= $err ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="form-box">

        <label>School:</label>
        <input type="text" name="school" value="<?= sanitize_input($edu['school']) ?>" required>

        <label>Degree:</label>
        <input type="text" name="degree" value="<?= sanitize_input($edu['degree']) ?>" required>

        <label>Start Year:</label>
        <input type="number" name="start_year" value="<?= sanitize_input($edu['start_year']) ?>" required>

        <label>End Year:</label>
        <input type="number" name="end_year" value="<?= sanitize_input($edu['end_year']) ?>">

        <label>Location:</label>
        <input type="text" name="location" value="<?= sanitize_input($edu['location']) ?>">

        <label>Description:</label>
        <textarea name="description"><?= sanitize_input($edu['description']) ?></textarea>

        <button type="submit" class="btn-primary">Update Education</button>
    </form>

</div>

<?php include '../includes/footer.php'; ?>
