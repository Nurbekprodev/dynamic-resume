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
    $skill_name = sanitize_input($_POST['skill_name'] ?? '');
    $level      = sanitize_input($_POST['level'] ?? '');
    $category   = sanitize_input($_POST['category'] ?? '');

    if ($skill_name === '') $errors[] = "Skill name is required.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO skills (skill_name, level, category) VALUES (?, ?, ?)");
        $stmt->execute([$skill_name, $level, $category]);
        
        header("Location: dashboard.php?success=skill_added");
        exit;
    }
}

include '../includes/header.php';
?>

<div class="page-container">

    <div class="page-header">
        <h2>Add Skill</h2>
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

        <label>Skill Name:</label>
        <input type="text" name="skill_name" required>

        <label>Level:</label>
        <input type="text" name="level">

        <label>Category:</label>
        <input type="text" name="category">

        <button type="submit" class="btn-primary">Add Skill</button>
    </form>

</div>

<?php include '../includes/footer.php'; ?>
