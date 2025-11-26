<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    die("You must <a href='../users/login.php'>login</a> first.");
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize_input($_POST['title'] ?? '');
    $description = sanitize_input($_POST['description'] ?? '');
    $link = sanitize_input($_POST['link'] ?? '');
    $start_year = intval($_POST['start_year'] ?? 0);
    $end_year = intval($_POST['end_year'] ?? 0);

    if ($title === '') $errors[] = "Project title is required.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO projects (title, description, link, start_year, end_year) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $link, $start_year ?: null, $end_year ?: null]);
        echo "<p>Project added successfully. <a href='dashboard.php'>Back to Dashboard</a></p>";
        exit;
    }
}
?>

<h2>Add Project</h2>

<?php if (!empty($errors)) foreach ($errors as $err) echo "<p style='color:red;'>$err</p>"; ?>

<form method="POST">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Link:</label><br>
    <input type="url" name="link"><br><br>

    <label>Start Year:</label><br>
    <input type="number" name="start_year"><br><br>

    <label>End Year:</label><br>
    <input type="number" name="end_year"><br><br>

    <button type="submit">Add Project</button>
</form>
