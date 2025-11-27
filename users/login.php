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
            // Login success
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: ../admin/dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = $valid_username !== true ? $valid_username : $valid_password;
    }
}
?>

<?php require_once '../includes/header.php'; ?>

<div class="login-page-wrapper container">

    <h2 class="page-title">Login</h2>

    <?php if ($error): ?>
        <p class="error-text"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="" class="form-box">

        <label>Username</label>
        <input type="text" name="username" required class="input-field">

        <label>Password</label>
        <input type="password" name="password" required class="input-field">

        <button type="submit" class="btn-primary">Login</button>
    </form>

    <p class="form-link">
        <a href="register.php">Create an Account</a>
    </p>

</div>

<?php require_once '../includes/footer.php'; ?>
