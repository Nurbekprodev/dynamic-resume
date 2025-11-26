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

// Fetch Experience, Education, Skills, Projects
$experiences = $pdo->query("SELECT * FROM experience ORDER BY start_year DESC")->fetchAll(PDO::FETCH_ASSOC);
$educations  = $pdo->query("SELECT * FROM education ORDER BY start_year DESC")->fetchAll(PDO::FETCH_ASSOC);
$skills      = $pdo->query("SELECT * FROM skills")->fetchAll(PDO::FETCH_ASSOC);
$projects    = $pdo->query("SELECT * FROM projects ORDER BY start_year DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?= require_once 'includes/header.php' ?>

<div class="dashboard-container container"> <!-- consistent spacing -->

    <!-- Resume Header -->
    <section class="resume-header">
        <div class="profile">
            <?php if (!empty($resume['avatar_path'])): ?>
                <img src="uploads/<?= sanitize_input($resume['avatar_path']) ?>" alt="Profile Picture" class="avatar">
            <?php endif; ?>
            <div class="intro">
                <h1 class="name"><?= sanitize_input($resume['full_name']) ?></h1>
                <h2 class="title"><?= sanitize_input($resume['title']) ?></h2>
                <p class="about"><?= nl2br(sanitize_input($resume['about'])) ?></p>
            </div>
        </div>

        <div class="contact">
            <p>Email: <?= sanitize_input($resume['email']) ?></p>
            <p>Phone: <?= sanitize_input($resume['phone']) ?></p>
            <p>Location: <?= sanitize_input($resume['location']) ?></p>
            <p>LinkedIn: <a href="<?= sanitize_input($resume['linkedin']) ?>"><?= sanitize_input($resume['linkedin']) ?></a></p>
            <p>GitHub: <a href="<?= sanitize_input($resume['github']) ?>"><?= sanitize_input($resume['github']) ?></a></p>
        </div>
    </section>

    <!-- Experience Section -->
    <section class="experience section-block" id="experience">
        <h3>Experience</h3>
        <?php if ($experiences): ?>
            <?php foreach ($experiences as $exp): ?>
                <article class="experience-item">
                    <h4><?= sanitize_input($exp['position']) ?> @ <?= sanitize_input($exp['company']) ?></h4>
                    <span class="period"><?= sanitize_input($exp['start_year']) ?> - <?= sanitize_input($exp['end_year'] ?: 'Present') ?></span>
                    <p><?= nl2br(sanitize_input($exp['description'])) ?></p>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No experience added yet.</p>
        <?php endif; ?>
    </section>

    <!-- Education Section -->
    <section class="education section-block" id="education">
        <h3>Education</h3>
        <?php if ($educations): ?>
            <?php foreach ($educations as $edu): ?>
                <article class="education-item">
                    <h4><?= sanitize_input($edu['degree']) ?> @ <?= sanitize_input($edu['school']) ?></h4>
                    <span class="period"><?= sanitize_input($edu['start_year']) ?> - <?= sanitize_input($edu['end_year'] ?: 'Present') ?></span>
                    <p><?= nl2br(sanitize_input($edu['description'])) ?></p>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No education added yet.</p>
        <?php endif; ?>
    </section>

    <!-- Skills Section -->
    <section class="skills section-block" id="skills">
        <h3>Skills</h3>
        <?php if ($skills): ?>
            <ul class="skills-list">
                <?php foreach ($skills as $skill): ?>
                    <li><?= sanitize_input($skill['skill_name']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No skills added yet.</p>
        <?php endif; ?>
    </section>

    <!-- Projects Section -->
    <section class="projects section-block" id="projects">
        <h3>Projects</h3>
        <?php if ($projects): ?>
            <?php foreach ($projects as $proj): ?>
                <article class="project-item">
                    <h4><?= sanitize_input($proj['title']) ?> (<?= sanitize_input($proj['start_year']) ?> - <?= sanitize_input($proj['end_year'] ?: 'Present') ?>)</h4>
                    <p><?= nl2br(sanitize_input($proj['description'])) ?></p>
                    <p>Link: <a href="<?= sanitize_input($proj['link']) ?>"><?= sanitize_input($proj['link']) ?></a></p>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No projects added yet.</p>
        <?php endif; ?>
    </section>

</div> <!-- end dashboard-container -->

<?= require_once 'includes/footer.php' ?>
