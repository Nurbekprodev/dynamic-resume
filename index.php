<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

// Fetch resume (single row)
$resume_stmt = $pdo->query("SELECT * FROM resume LIMIT 1");
$resumes = $resume_stmt ? $resume_stmt->fetchAll(PDO::FETCH_ASSOC) : [];
$resume = !empty($resumes) ? $resumes[0] : [
    'full_name'   => 'Your Name',
    'title'       => 'Your Title',
    'about'       => '',
    'email'       => '',
    'phone'       => '',
    'location'    => '',
    'linkedin'    => '',
    'github'      => '',
    'avatar_path' => ''
];

// Experience
$exp_stmt = $pdo->query("SELECT * FROM experience ORDER BY start_year DESC");
$experiences = $exp_stmt ? $exp_stmt->fetchAll(PDO::FETCH_ASSOC) : [];

// Education
$edu_stmt = $pdo->query("SELECT * FROM education ORDER BY start_year DESC");
$educations = $edu_stmt ? $edu_stmt->fetchAll(PDO::FETCH_ASSOC) : [];

// Skills
$skills_stmt = $pdo->query("SELECT * FROM skills");
$skills = $skills_stmt ? $skills_stmt->fetchAll(PDO::FETCH_ASSOC) : [];

// Projects
$proj_stmt = $pdo->query("SELECT * FROM projects ORDER BY start_year DESC");
$projects = $proj_stmt ? $proj_stmt->fetchAll(PDO::FETCH_ASSOC) : [];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= sanitize_input($resume['full_name']) ?> - Resume</title>
</head>
<body>

<h1><?= sanitize_input($resume['full_name']) ?></h1>
<h2><?= sanitize_input($resume['title']) ?></h2>

<?php if (!empty($resume['avatar_path'])): ?>
    <img src="<?= sanitize_input($resume['avatar_path']) ?>" alt="Profile Picture" width="120">
<?php endif; ?>

<p><?= nl2br(sanitize_input($resume['about'])) ?></p>

<p>Email: <?= sanitize_input($resume['email']) ?></p>
<p>Phone: <?= sanitize_input($resume['phone']) ?></p>
<p>Location: <?= sanitize_input($resume['location']) ?></p>

<p>
    LinkedIn:
    <a href="<?= sanitize_input($resume['linkedin']) ?>">
        <?= sanitize_input($resume['linkedin']) ?>
    </a>
</p>

<p>
    GitHub:
    <a href="<?= sanitize_input($resume['github']) ?>">
        <?= sanitize_input($resume['github']) ?>
    </a>
</p>

<hr>

<h3>Experience</h3>
<?php if (!empty($experiences)): ?>
    <?php foreach ($experiences as $exp): ?>
        <p>
            <strong><?= sanitize_input($exp['position']) ?></strong>
            at <?= sanitize_input($exp['company']) ?>
            (<?= sanitize_input($exp['start_year']) ?> - <?= sanitize_input($exp['end_year'] ?: 'Present') ?>)
        </p>
        <p><?= nl2br(sanitize_input($exp['description'])) ?></p>
        <br>
    <?php endforeach; ?>
<?php else: ?>
    <p>No experience added yet.</p>
<?php endif; ?>

<hr>

<h3>Education</h3>
<?php if (!empty($educations)): ?>
    <?php foreach ($educations as $edu): ?>
        <p>
            <strong><?= sanitize_input($edu['degree']) ?></strong>
            at <?= sanitize_input($edu['school']) ?>
            (<?= sanitize_input($edu['start_year']) ?> - <?= sanitize_input($edu['end_year'] ?: 'Present') ?>)
        </p>
        <p><?= nl2br(sanitize_input($edu['description'])) ?></p>
        <br>
    <?php endforeach; ?>
<?php else: ?>
    <p>No education added yet.</p>
<?php endif; ?>

<hr>

<h3>Skills</h3>
<?php if (!empty($skills)): ?>
    <ul>
        <?php foreach ($skills as $skill): ?>
            <li><?= sanitize_input($skill['skill_name']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No skills added yet.</p>
<?php endif; ?>

<hr>

<h3>Projects</h3>
<?php if (!empty($projects)): ?>
    <?php foreach ($projects as $proj): ?>
        <p>
            <strong><?= sanitize_input($proj['title']) ?></strong>
            (<?= sanitize_input($proj['start_year']) ?> - <?= sanitize_input($proj['end_year'] ?: 'Present') ?>)
        </p>
        <p><?= nl2br(sanitize_input($proj['description'])) ?></p>
        <p>
            Link:
            <a href="<?= sanitize_input($proj['link']) ?>">
                <?= sanitize_input($proj['link']) ?>
            </a>
        </p>
        <br>
    <?php endforeach; ?>
<?php else: ?>
    <p>No projects added yet.</p>
<?php endif; ?>

</body>
</html>
