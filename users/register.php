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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username_check = validate_username($_POST['username']);
    $password_check = validate_password($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($username_check !== true) {
        $error['username'] = $username_check;
    } else {
        $username = sanitize_input($_POST['username']);
    }

    if ($password_check !== true) {
        $error['password'] = $password_check;
    }

    if ($confirm_password !== $_POST['password']) {
        $error['confirm_password'] = "Passwords do not match.";
    }

    // If fields are valid, check duplicates
    if (empty($error['username']) && empty($error['password']) && empty($error['confirm_password'])) {

        // Check duplicate username
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);

        if ($stmt->fetch()) {
            $error['username'] = "This username is already taken.";
        } else {
            $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $sql = "INSERT INTO users (username, password)
                    VALUES (:username, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'username' => $username,
                'password' => $hashed_password
            ]);

            header("Location: login.php?registered=1");
            exit;
        }
    }
}
?>

<?php require_once '../includes/header.php'; ?>

<div class="login-page-wrapper container"> <!-- same wrapper -->

    <h2 class="page-title">Create an Account</h2>

    <form method="POST" action="" class="form-box">

        <label>Username</label>
        <input type="text" name="username" class="input-field" value="<?= htmlspecialchars($username) ?>" required>
        <?php if ($error['username']): ?>
            <p class="error-text"><?= htmlspecialchars($error['username']) ?></p>
        <?php endif; ?>

        <label>Password</label>
        <input type="password" name="password" class="input-field" required>
        <?php if ($error['password']): ?>
            <p class="error-text"><?= htmlspecialchars($error['password']) ?></p>
        <?php endif; ?>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" class="input-field" required>
        <?php if ($error['confirm_password']): ?>
            <p class="error-text"><?= htmlspecialchars($error['confirm_password']) ?></p>
        <?php endif; ?>

        <button type="submit" class="btn-primary">Register</button>

    </form>

    <p class="form-link">
        Already have an account? <a href="login.php">Login</a>
    </p>

</div>

<?php require_once '../includes/footer.php'; ?>
