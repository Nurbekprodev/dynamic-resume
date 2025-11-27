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

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title']);
    $description = trim($_POST['description']);
    $link        = trim($_POST['link']);
    $start_year  = $_POST['start_year'] ? intval($_POST['start_year']) : null;
    $end_year    = $_POST['end_year'] ? intval($_POST['end_year']) : null;

    if ($title === '') $errors[] = "Project title is required.";

    if (empty($errors)) {
        $update = $pdo->prepare("
            UPDATE projects 
            SET title=?, description=?, link=?, start_year=?, end_year=? 
            WHERE id=?
        ");
        $update->execute([$title, $description, $link, $start_year, $end_year, $id]);

        header("Location: dashboard.php?success=project_updated");
        exit;
    }
}

include '../includes/header.php';
?>

<div class="page-container">

    <div class="page-header">
        <h2>Edit Project</h2>
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

        <label>Title:</label>
        <input type="text" name="title" value="<?= sanitize_input($proj['title']) ?>" required>

        <label>Description:</label>
        <textarea name="description"><?= sanitize_input($proj['description']) ?></textarea>

        <label>Link:</label>
        <input type="text" name="link" value="<?= sanitize_input($proj['link']) ?>">

        <label>Start Year:</label>
        <input type="number" name="start_year" value="<?= sanitize_input($proj['start_year']) ?>">

        <label>End Year:</label>
        <input type="number" name="end_year" value="<?= sanitize_input($proj['end_year']) ?>">

        <button type="submit" class="btn-primary">Update Project</button>
    </form>

</div>

<?php include '../includes/footer.php'; ?>
