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
    $company     = sanitize_input($_POST['company'] ?? '');
    $position    = sanitize_input($_POST['position'] ?? '');
    $start_year  = intval($_POST['start_year'] ?? 0);
    $end_year    = intval($_POST['end_year'] ?? 0);
    $location    = sanitize_input($_POST['location'] ?? '');
    $description = sanitize_input($_POST['description'] ?? '');

    if ($company === '') $errors[] = "Company name is required.";
    if ($position === '') $errors[] = "Position is required.";
    if ($start_year <= 0) $errors[] = "Start year is required.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            INSERT INTO experience (company, position, start_year, end_year, location, description)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$company, $position, $start_year, $end_year ?: null, $location, $description]);
        
        header("Location: dashboard.php?success=experience_added");
        exit;
    }
}

include '../includes/header.php';
?>

<div class="page-container">

    <div class="page-header">
        <h2>Add Experience</h2>
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
        <input type="text" name="company" required>

        <label>Position:</label>
        <input type="text" name="position" required>

        <label>Start Year:</label>
        <input type="number" name="start_year" required>

        <label>End Year:</label>
        <input type="number" name="end_year">

        <label>Location:</label>
        <input type="text" name="location">

        <label>Description:</label>
        <textarea name="description"></textarea>

        <button type="submit" class="btn-primary">Add Experience</button>
    </form>

</div>

<?php include '../includes/footer.php'; ?>
