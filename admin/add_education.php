<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    die("You must <a href='../users/login.php'>login</a> first.");
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school = sanitize_input($_POST['school'] ?? '');
    $degree = sanitize_input($_POST['degree'] ?? '');
    $start_year = intval($_POST['start_year'] ?? 0);
    $end_year = intval($_POST['end_year'] ?? 0);
    $location = sanitize_input($_POST['location'] ?? '');
    $description = sanitize_input($_POST['description'] ?? '');

    if ($school === '') $errors[] = "School name is required.";
    if ($degree === '') $errors[] = "Degree is required.";
    if ($start_year <= 0) $errors[] = "Start year is required.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO education (school, degree, start_year, end_year, location, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$school, $degree, $start_year, $end_year ?: null, $location, $description]);
        echo "<p>Education added successfully. <a href='dashboard.php'>Back to Dashboard</a></p>";
        exit;
    }
}
?>

<h2>Add Education</h2>

<?php if (!empty($errors)) foreach ($errors as $err) echo "<p style='color:red;'>$err</p>"; ?>

<form method="POST">
    <label>School:</label><br>
    <input type="text" name="school" required><br><br>

    <label>Degree:</label><br>
    <input type="text" name="degree" required><br><br>

    <label>Start Year:</label><br>
    <input type="number" name="start_year" required><br><br>

    <label>End Year:</label><br>
    <input type="number" name="end_year"><br><br>

    <label>Location:</label><br>
    <input type="text" name="location"><br><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea><br><br>

    <button type="submit">Add Education</button>
</form>
