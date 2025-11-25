<?php
session_start();
require_once 'db_connect.php';
require_once 'includes/functions.php';

$error = [
    'username' => '',
    'password' => ''
];

$username = ''; // initialize for HTML value

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_check = validate_username($_POST['username']);
    $password_check = validate_password($_POST['password']);

    if ($username_check !== true) {
        $error['username'] = $username_check;
    } else {
        $username = htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8');
    }

    if ($password_check !== true) {
        $error['password'] = $password_check;
    } else {
        $password = $_POST['password']; // use for password_verify
    }

    if (empty($error['username']) && empty($error['password'])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $user['id'];
            header("Location: admin/dashboard.php");
            exit;
        } else {
            $error['password'] = 'Invalid username or password';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Username" required value="<?= isset($username) ? $username : '' ?>">
        <br><?= $error['username'] ?><br>

        <input type="password" name="password" placeholder="Password" required>
        <br><?= $error['password'] ?><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
