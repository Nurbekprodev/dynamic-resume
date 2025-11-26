<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>You must <a href='../users/login.php'>login</a> first.</p>";
    exit;
}

// Fetch tables
$resume = $pdo->query("SELECT * FROM resume LIMIT 1")->fetch();
$experiences = $pdo->query("SELECT * FROM experience ORDER BY start_year DESC")->fetchAll();
$educations = $pdo->query("SELECT * FROM education ORDER BY start_year DESC")->fetchAll();
$skills = $pdo->query("SELECT * FROM skills")->fetchAll();
$projects = $pdo->query("SELECT * FROM projects ORDER BY start_year DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

<h2>Dashboard</h2>

<p>Welcome, <?= sanitize_input($_SESSION['username']) ?>!</p>
<hr>

<!-- Resume Section -->
<h3>Resume</h3>
<?php if ($resume): ?>
    <p><strong>Name:</strong> <?= sanitize_input($resume['full_name']) ?></p>
    <p><strong>Title:</strong> <?= sanitize_input($resume['title']) ?></p>
    <p><strong>Email:</strong> <?= sanitize_input($resume['email']) ?></p>
    <p><strong>Phone:</strong> <?= sanitize_input($resume['phone']) ?></p>
    <p><strong>Location:</strong> <?= sanitize_input($resume['location']) ?></p>
    <p><strong>About:</strong> <?= nl2br(sanitize_input($resume['about'])) ?></p>
    <p>
        <a href="edit_profile.php?id=<?= $resume['id'] ?>">Edit Resume</a>
    </p>
<?php else: ?>
    <p>No resume found.</p>
    <p><a href="edit_profile.php">Create Resume</a></p>
<?php endif; ?>
<hr>


<!-- Experience Section -->
<h3>Experience</h3>
<?php if ($experiences): ?>
<table border="1" cellpadding="5">
    <tr>
        <th>Company</th>
        <th>Position</th>
        <th>Years</th>
        <th>Location</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($experiences as $exp): ?>
    <tr>
        <td><?= sanitize_input($exp['company']) ?></td>
        <td><?= sanitize_input($exp['position']) ?></td>
        <td><?= sanitize_input($exp['start_year']) ?> - <?= sanitize_input($exp['end_year'] ?: 'Present') ?></td>
        <td><?= sanitize_input($exp['location']) ?></td>
        <td><?= nl2br(sanitize_input($exp['description'])) ?></td>
        <td>
            <a href="edit_experience.php?id=<?= $exp['id'] ?>">Edit</a> |
            <a href="delete.php?table=experience&id=<?= $exp['id'] ?>">Delete</a>

        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>No experience added.</p>
<?php endif; ?>
<p><a href="add_experience.php">Add Experience</a></p>
<hr>

<!-- Education Section -->
<h3>Education</h3>
<?php if ($educations): ?>
<table border="1" cellpadding="5">
    <tr>
        <th>School</th>
        <th>Degree</th>
        <th>Years</th>
        <th>Location</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($educations as $edu): ?>
    <tr>
        <td><?= sanitize_input($edu['school']) ?></td>
        <td><?= sanitize_input($edu['degree']) ?></td>
        <td><?= sanitize_input($edu['start_year']) ?> - <?= sanitize_input($edu['end_year'] ?: 'Present') ?></td>
        <td><?= sanitize_input($edu['location']) ?></td>
        <td><?= nl2br(sanitize_input($edu['description'])) ?></td>
        <td>
            <a href="edit_education.php?id=<?= $edu['id'] ?>">Edit</a> |
            <a href="delete.php?table=education&id=<?= $edu['id'] ?>">Delete</a>

        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>No education added.</p>
<?php endif; ?>
<p><a href="add_education.php">Add Education</a></p>
<hr>

<!-- Skills Section -->
<h3>Skills</h3>
<?php if ($skills): ?>
<table border="1" cellpadding="5">
    <tr>
        <th>Skill</th>
        <th>Level</th>
        <th>Category</th>
        
        <th>Actions</th>
    </tr>
    <?php foreach ($skills as $skill): ?>
    <tr>
        <td><?= sanitize_input($skill['skill_name']) ?></td>
        <td><?= sanitize_input($skill['level']) ?></td>
        <td><?= sanitize_input($skill['category']) ?></td>
        
        <td>
            <a href="edit_skills.php?id=<?= $skill['id'] ?>">Edit</a> |
            <a href="delete.php?table=skills&id=<?= $skill['id'] ?>">Delete</a>

        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>No skills added.</p>
<?php endif; ?>
<p><a href="add_skills.php">Add Skill</a></p>
<hr>

<!-- Projects Section -->
<h3>Projects</h3>
<?php if ($projects): ?>
<table border="1" cellpadding="5">
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Link</th>
        <th>Start Year</th>
        <th>End Year</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($projects as $proj): ?>
    <tr>
        <td><?= sanitize_input($proj['title']) ?></td>
        <td><?= nl2br(sanitize_input($proj['description'])) ?></td>
        <td><a href="<?= sanitize_input($proj['link']) ?>"><?= sanitize_input($proj['link']) ?></a></td>
        <td><?= sanitize_input($proj['start_year']) ?></td>
        <td><?= sanitize_input($proj['end_year'] ?: 'Present') ?></td>
        <td>
            <a href="edit_projects.php?id=<?= $proj['id'] ?>">Edit</a> |
            <a href="delete.php?table=projects&id=<?= $proj['id'] ?>">Delete</a>

        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>No projects added.</p>
<?php endif; ?>
<p><a href="add_projects.php">Add Project</a></p>
<hr>


<p><a href="../users/logout.php">Logout</a></p>

</body>
</html>
