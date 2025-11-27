<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = sanitize_input($_POST['title'] ?? '');
    $description = sanitize_input($_POST['description'] ?? '');
    $link        = sanitize_input($_POST['link'] ?? '');
    $start_year  = intval($_POST['start_year'] ?? 0);
    $end_year    = intval($_POST['end_year'] ?? 0);

    if ($title === '') $errors[] = "Project title is required.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            INSERT INTO projects (title, description, link, start_year, end_year)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$title, $description, $link, $start_year ?: null, $end_year ?: null]);
        
        header("Location: dashboard.php?success=project_added");
        exit;
    }
}

include '../includes/header.php';
?>

<div class="page-container">

    <div class="page-header">
        <h2>Add Project</h2>
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
        <input type="text" name="title" required>

        <label>Description:</label>
        <textarea name="description"></textarea>

        <label>Link:</label>
        <input type="url" name="link">

        <label>Start Year:</label>
        <input type="number" name="start_year">

        <label>End Year:</label>
        <input type="number" name="end_year">

        <button type="submit" class="btn-primary">Add Project</button>
    </form>

</div>

<?php include '../includes/footer.php'; ?>
