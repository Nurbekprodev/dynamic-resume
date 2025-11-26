<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    $valid_username = validate_username($username);
    $valid_password = validate_password($password);

    if ($valid_username === true && $valid_password === true) {
        // Fetch user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Correct login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: ../admin/dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        // Show first validation error
        $error = $valid_username !== true ? $valid_username : $valid_password;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

<p><a href="register.php">Create an Account</a></p>

</body>
</html>
