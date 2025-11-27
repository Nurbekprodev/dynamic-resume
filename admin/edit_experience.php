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

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company     = trim($_POST['company']);
    $position    = trim($_POST['position']);
    $start_year  = intval($_POST['start_year']);
    $end_year    = $_POST['end_year'] ? intval($_POST['end_year']) : null;
    $location    = trim($_POST['location']);
    $description = trim($_POST['description']);

    if ($company === '') $errors[] = "Company name is required.";
    if ($position === '') $errors[] = "Position is required.";
    if ($start_year <= 0) $errors[] = "Start year is required.";

    if (empty($errors)) {
        $update = $pdo->prepare("
            UPDATE experience 
            SET company=?, position=?, start_year=?, end_year=?, location=?, description=? 
            WHERE id=?
        ");
        $update->execute([$company, $position, $start_year, $end_year, $location, $description, $id]);

        header("Location: dashboard.php?success=experience_updated");
        exit;
    }
}

include '../includes/header.php';
?>

<div class="page-container">

    <div class="page-header">
        <h2>Edit Experience</h2>
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

        <label>Company:</label>
        <input type="text" name="company" value="<?= sanitize_input($exp['company']) ?>" required>

        <label>Position:</label>
        <input type="text" name="position" value="<?= sanitize_input($exp['position']) ?>" required>

        <label>Start Year:</label>
        <input type="number" name="start_year" value="<?= sanitize_input($exp['start_year']) ?>" required>

        <label>End Year:</label>
        <input type="number" name="end_year" value="<?= sanitize_input($exp['end_year']) ?>">

        <label>Location:</label>
        <input type="text" name="location" value="<?= sanitize_input($exp['location']) ?>">

        <label>Description:</label>
        <textarea name="description"><?= sanitize_input($exp['description']) ?></textarea>

        <button type="submit" class="btn-primary">Update Experience</button>
    </form>

</div>

<?php include '../includes/footer.php'; ?>
