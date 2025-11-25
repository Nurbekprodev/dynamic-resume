<?php
session_start();
require_once '../includes/db_connect.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: ../users/login.php");
    exit;
}

// Get parameters
$type = $_GET['type'] ?? '';
$id   = intval($_GET['id'] ?? 0);

if(!$type || !$id){
    header("Location: dashboard.php");
    exit;
}

// Determine table based on type
$valid_types = ['experience', 'education', 'skills', 'projects'];
if(!in_array($type, $valid_types)){
    header("Location: dashboard.php");
    exit;
}

// Delete the entry
$stmt = $pdo->prepare("DELETE FROM {$type} WHERE id = :id");
$stmt->execute(['id' => $id]);

header("Location: dashboard.php?deleted=1");
exit;
