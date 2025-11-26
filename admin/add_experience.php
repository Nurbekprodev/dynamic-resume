<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    die("You must <a href='../users/login.php'>login</a> first.");
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company = sanitize_input($_POST['company'] ?? '');
    $position = sanitize_input($_POST['position'] ?? '');
    $start_year = intval($_POST['start_year'] ?? 0);
    $end_year = intval($_POST['end_year'] ?? 0);
    $location = sanitize_input($_POST['location'] ?? '');
    $description = sanitize_input($_POST['description'] ?? '');

    if ($company === '') $errors[] = "Company name is required.";
    if ($position === '') $errors[] = "Position is required.";
    if ($start_year <= 0) $errors[] = "Start year is required.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO experience (company, position, start_year, end_year, location, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$company, $position, $start_year, $end_year ?: null, $location, $description]);
        echo "<p>Experience added successfully. <a href='dashboard.php'>Back to Dashboard</a></p>";
        exit;
    }
}
?>

<h2>Add Experience</h2>

<?php if (!empty($errors)) foreach ($errors as $err) echo "<p style='color:red;'>$err</p>"; ?>

<form method="POST">
    <label>Company:</label><br>
    <input type="text" name="company" required><br><br>

    <label>Position:</label><br>
    <input type="text" name="position" required><br><br>

    <label>Start Year:</label><br>
    <input type="number" name="start_year" required><br><br>

    <label>End Year:</label><br>
    <input type="number" name="end_year"><br><br>

    <label>Location:</label><br>
    <input type="text" name="location"><br><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea><br><br>

    <button type="submit">Add Experience</button>
</form>
