<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MyResume</title>
    <!-- Link to global CSS -->
    <link rel="stylesheet" href="/dynamic-resume/css/style.css">
</head>
<body>
<header>
    <div class="container header-container">
        
        <div class="logo">MyResume</div>

        <nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/dynamic-resume/admin/dashboard.php">Dashboard</a>
                <a href="/dynamic-resume/index.php">View Public Resume</a>
                <a href="/dynamic-resume/users/logout.php">
                    Logout (<?= htmlspecialchars($_SESSION['username']) ?>)
                </a>
            <?php else: ?>
                <a href="/dynamic-resume/index.php">Home</a>
                <a href="/dynamic-resume/about.php">About</a>
                <a href="/dynamic-resume/users/login.php">Login</a>

                <div class="nav-dropdown">
                    <a href="#" class="dropdown-toggle">Navigate ▼</a>
                    <div class="nav-dropdown-menu">
                        <a href="#education">Education</a>
                        <a href="#experience">Experience</a>
                        <a href="#skills">Skills</a>
                        <a href="#projects">Projects</a>
                    </div>
                </div>

            <?php endif; ?>
        </nav>

    </div>
</header>



<script>
    const dropdown = document.querySelector('.nav-dropdown');

    if (dropdown) {
        const link = dropdown.querySelector('a');  // The clickable text
        const menu = dropdown.querySelector('.nav-dropdown-menu');

        link.addEventListener('click', (e) => {
            e.preventDefault();
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target)) {
                menu.style.display = 'none';
            }
        });
    }
</script>

