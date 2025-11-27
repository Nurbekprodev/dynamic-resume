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

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skill_name = trim($_POST['skill_name']);
    $level      = trim($_POST['level']);
    $category   = trim($_POST['category']);

    if ($skill_name === '') $errors[] = "Skill name is required.";

    if (empty($errors)) {
        $update = $pdo->prepare("UPDATE skills SET skill_name=?, level=?, category=? WHERE id=?");
        $update->execute([$skill_name, $level, $category, $id]);
        header("Location: dashboard.php?success=skill_updated");
        exit;
    }
}

include '../includes/header.php';
?>

<div class="page-container">

    <div class="page-header">
        <h2>Edit Skill</h2>
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
        <input type="text" name="skill_name" value="<?= sanitize_input($skill['skill_name']) ?>" required>

        <label>Level:</label>
        <input type="text" name="level" value="<?= sanitize_input($skill['level']) ?>">

        <label>Category:</label>
        <input type="text" name="category" value="<?= sanitize_input($skill['category']) ?>">

        <button type="submit" class="btn-primary">Update Skill</button>
    </form>

</div>

<?php include '../includes/footer.php'; ?>
