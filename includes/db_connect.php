<?php
$type = 'mysql';
$host = 'localhost';
$dbname = 'resume_db';
$charset = 'utf8mb4';
$user = 'root';
$pass = '';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$dsn = "$type:host=$host;dbname=$dbname;charset=$charset";

try{
    $pdo = new PDO($dsn, $user, $pass, $options);
}catch(PDOException $e){
    error_log("DB Connection Error: " . $e->getMessage());
    die("Database connection failed.");
}
