<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

// Fetch resume
$resume_stmt = $pdo->query("SELECT * FROM resume LIMIT 1");
$resumes = $resume_stmt ? $resume_stmt->fetchAll() : [];
$resume = !empty($resumes) ? $resumes[0] : [
    'full_name'   => 'Your Name',
    'title'       => 'Your Title',
    'about'       => 'About me section is empty.',
    'email'       => '',
    'phone'       => '',
    'location'    => '',
    'linkedin'    => '',
    'github'      => '',
    'avatar_path' => ''
];

// Fetch experiences
$exp_stmt = $pdo->query("SELECT * FROM experience ORDER BY start_year DESC");
$experiences = $exp_stmt ? $exp_stmt->fetchAll() : [];

// Fetch education
$edu_stmt = $pdo->query("SELECT * FROM education ORDER BY start_year DESC");
$educations = $edu_stmt ? $edu_stmt->fetchAll() : [];

// Fetch skills
$skills_stmt = $pdo->query("SELECT * FROM skills");
$skills = $skills_stmt ? $skills_stmt->fetchAll() : [];

// Fetch projects
$proj_stmt = $pdo->query("SELECT * FROM projects ORDER BY start_year DESC");
$projects = $proj_stmt ? $proj_stmt->fetchAll() : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= sanitize_input($resume['full_name']) ?> - Resume</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="p-base">

    <!-- Header / Resume Info -->
    <header class="section flex-col flex-center">
        <?php if(!empty($resume['avatar_path'])): ?>
            <img src="<?= sanitize_input($resume['avatar_path']) ?>" alt="Profile Picture" class="avatar">
        <?php endif; ?>
        <h1 class="text-heading"><?= sanitize_input($resume['full_name']) ?></h1>
        <h2 class="text-primary mb-base"><?= sanitize_input($resume['title']) ?></h2>
        <p class="mb-base"><?= nl2br(sanitize_input($resume['about'])) ?></p>
        <p>Email: <?= sanitize_input($resume['email']) ?></p>
        <p>Phone: <?= sanitize_input($resume['phone']) ?></p>
        <p>Location: <?= sanitize_input($resume['location']) ?></p>
        <p>LinkedIn: <a href="<?= sanitize_input($resume['linkedin']) ?>"><?= sanitize_input($resume['linkedin']) ?></a></p>
        <p>GitHub: <a href="<?= sanitize_input($resume['github']) ?>"><?= sanitize_input($resume['github']) ?></a></p>
    </header>

    <!-- Experience Section -->
    <section class="section gap-section">
        <h3 class="section-title">Experience</h3>
        <?php if(!empty($experiences)): ?>
            <?php foreach($experiences as $exp): ?>
                <div class="card">
                    <strong><?= sanitize_input($exp['job_title']) ?></strong> at <?= sanitize_input($exp['company_name']) ?>
                    (<?= sanitize_input($exp['start_year']) ?> - <?= sanitize_input($exp['end_year'] ?: 'Present') ?>)
                    <p><?= nl2br(sanitize_input($exp['description'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-secondary">No experience added yet. Please check back later.</p>
        <?php endif; ?>
    </section>

    <!-- Education Section -->
    <section class="section gap-section">
        <h3 class="section-title">Education</h3>
        <?php if(!empty($educations)): ?>
            <?php foreach($educations as $edu): ?>
                <div class="card">
                    <strong><?= sanitize_input($edu['degree']) ?></strong> at <?= sanitize_input($edu['school']) ?>
                    (<?= sanitize_input($edu['start_year']) ?> - <?= sanitize_input($edu['end_year'] ?: 'Present') ?>)
                    <p><?= nl2br(sanitize_input($edu['description'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-secondary">No education added yet. Please check back later.</p>
        <?php endif; ?>
    </section>

    <!-- Skills Section -->
    <section class="section gap-section">
        <h3 class="section-title">Skills</h3>
        <?php if(!empty($skills)): ?>
            <ul>
                <?php foreach($skills as $skill): ?>
                    <li><?= sanitize_input($skill['skill_name']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-secondary">No skills added yet. Please check back later.</p>
        <?php endif; ?>
    </section>

    <!-- Projects Section -->
    <section class="section gap-section">
        <h3 class="section-title">Projects</h3>
        <?php if(!empty($projects)): ?>
            <?php foreach($projects as $proj): ?>
                <div class="card">
                    <strong><?= sanitize_input($proj['title']) ?></strong>
                    (<?= sanitize_input($proj['start_year']) ?> - <?= sanitize_input($proj['end_year'] ?: 'Present') ?>)
                    <p><?= nl2br(sanitize_input($proj['description'])) ?></p>
                    <p>Link: <a href="<?= sanitize_input($proj['link']) ?>"><?= sanitize_input($proj['link']) ?></a></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-secondary">No projects added yet. Please check back later.</p>
        <?php endif; ?>
    </section>

</body>
</html>
