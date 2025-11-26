<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    die("You must <a href='../users/login.php'>login</a> first.");
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skill_name = sanitize_input($_POST['skill_name'] ?? '');
    $level = sanitize_input($_POST['level'] ?? '');
    $category = sanitize_input($_POST['category'] ?? '');

    if ($skill_name === '') $errors[] = "Skill name is required.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO skills (skill_name, level, category) VALUES (?, ?, ?)");
        $stmt->execute([$skill_name, $level, $category]);
        echo "<p>Skill added successfully. <a href='dashboard.php'>Back to Dashboard</a></p>";
        exit;
    }
}
?>

<h2>Add Skill</h2>

<?php if (!empty($errors)) foreach ($errors as $err) echo "<p style='color:red;'>$err</p>"; ?>

<form method="POST">
    <label>Skill Name:</label><br>
    <input type="text" name="skill_name" required><br><br>

    <label>Level:</label><br>
    <input type="text" name="level"><br><br>

    <label>Category:</label><br>
    <input type="text" name="category"><br><br>

    <button type="submit">Add Skill</button>
</form>
