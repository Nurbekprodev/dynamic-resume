<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    die("You must <a href='../users/login.php'>login</a> first.");
}

// Validate table and ID
$allowed_tables = ['experience', 'education', 'skills', 'projects', 'resume']; // add more if needed

$table = $_GET['table'] ?? '';
$id = $_GET['id'] ?? '';

if (!in_array($table, $allowed_tables) || !is_numeric($id)) {
    die("Invalid request.");
}

$id = intval($id);

// Delete record
$stmt = $pdo->prepare("DELETE FROM $table WHERE id=?");
$stmt->execute([$id]);

// Redirect back
header("Location: dashboard.php");
exit;
