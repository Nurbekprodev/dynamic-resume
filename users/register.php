<?php
session_start();

require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

$error = [
    'username'         => '',
    'password'         => '',
    'confirm_password' => ''
];


$username = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Validate input

    $username_check = validate_username($_POST['username']);
    $password_check = validate_password($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if($username_check !== true){
        $error['username'] = $username_check;
    }else{
        $username = sanitize_input($_POST['username']);
    }

    if($password_check !== true){
        $error['password'] = $password_check;
    }

    if($confirm_password !== $_POST['password']){
        $error['confirm_password'] = "Passwords do not match.";
    }

    // If no error, insert into database
    if(empty($error['username']) && empty($error['password']) && empty($error['confirm_password'])){
        // Check for duplicate username
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    if ($stmt->fetch()) {
        $error['username'] = "This username is already taken.";
    }else{ 
        $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (username, password)
            VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username, 
            'password' => $hashed_password
        ]);

        // Redirect to login
        header("Location: login.php?registered=1");
        exit;
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
<form action="" method="POST">
    <input type="text" name="username" placeholder="Username" value="<?= isset($username) ? $username : '' ?>" required>
    <br><?= $error['username'] ?><br>

    <input type="password" name="password" placeholder="Password" required>
    <br><?= $error['password'] ?><br>

    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    <br><?= $error['confirm_password'] ?><br>

    <button type="submit">Register</button>
</form>
</body>
</html>