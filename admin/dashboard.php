<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: ../users/login.php");
    exit;
}

// Success message for deletion
$deleted = isset($_GET['deleted']) ? "Entry deleted successfully." : "";

// Fetch all entries
$experience = $pdo->query("SELECT * FROM experience ORDER BY start_year DESC")->fetchAll();
$education  = $pdo->query("SELECT * FROM education ORDER BY start_year DESC")->fetchAll();
$skills     = $pdo->query("SELECT * FROM skills ORDER BY skill_name ASC")->fetchAll();
$projects   = $pdo->query("SELECT * FROM projects ORDER BY title ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body class="p-base">

<h1 class="text-heading">Admin Dashboard</h1>

<?php if($deleted): ?>
    <div class="card text-primary"><?= $deleted ?></div>
<?php endif; ?>

<!-- EXPERIENCE SECTION -->
<div class="section">
    <h2 class="section-title">Experience</h2>
    <a href="add.php?type=experience" class="button mb-base">Add New Experience</a>
    <?php if($experience): ?>
        <table>
            <tr>
                <th>Job Title</th>
                <th>Company</th>
                <th>Years</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php foreach($experience as $exp): ?>
            <tr>
                <td><?= htmlspecialchars($exp['job_title']) ?></td>
                <td><?= htmlspecialchars($exp['company_name']) ?></td>
                <td><?= htmlspecialchars($exp['start_year']) ?> - <?= htmlspecialchars($exp['end_year'] ?? 'Present') ?></td>
                <td><?= htmlspecialchars($exp['description']) ?></td>
                <td>
                    <a href="edit.php?type=experience&id=<?= $exp['id'] ?>" class="button">Edit</a>
                    <a href="delete.php?type=experience&id=<?= $exp['id'] ?>" onclick="return confirm('Are you sure you want to delete this experience?');" class="button">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No experience entries yet.</p>
    <?php endif; ?>
</div>

<!-- EDUCATION SECTION -->
<div class="section">
    <h2 class="section-title">Education</h2>
    <a href="add.php?type=education" class="button mb-base">Add New Education</a>
    <?php if($education): ?>
        <table>
            <tr>
                <th>Degree</th>
                <th>Institution</th>
                <th>Years</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php foreach($education as $edu): ?>
            <tr>
                <td><?= htmlspecialchars($edu['degree']) ?></td>
                <td><?= htmlspecialchars($edu['institution']) ?></td>
                <td><?= htmlspecialchars($edu['start_year']) ?> - <?= htmlspecialchars($edu['end_year'] ?? 'Present') ?></td>
                <td><?= htmlspecialchars($edu['description']) ?></td>
                <td>
                    <a href="edit.php?type=education&id=<?= $edu['id'] ?>" class="button">Edit</a>
                    <a href="delete.php?type=education&id=<?= $edu['id'] ?>" onclick="return confirm('Are you sure you want to delete this education?');" class="button">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No education entries yet.</p>
    <?php endif; ?>
</div>

<!-- SKILLS SECTION -->
<div class="section">
    <h2 class="section-title">Skills</h2>
    <a href="add.php?type=skills" class="button mb-base">Add New Skill</a>
    <?php if($skills): ?>
        <table>
            <tr>
                <th>Skill</th>
                <th>Level</th>
                <th>Actions</th>
            </tr>
            <?php foreach($skills as $skill): ?>
            <tr>
                <td><?= htmlspecialchars($skill['name']) ?></td>
                <td><?= htmlspecialchars($skill['level']) ?></td>
                <td>
                    <a href="edit.php?type=skills&id=<?= $skill['id'] ?>" class="button">Edit</a>
                    <a href="delete.php?type=skills&id=<?= $skill['id'] ?>" onclick="return confirm('Are you sure you want to delete this skill?');" class="button">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No skills added yet.</p>
    <?php endif; ?>
</div>

<!-- PROJECTS SECTION -->
<div class="section">
    <h2 class="section-title">Projects</h2>
    <a href="add.php?type=projects" class="button mb-base">Add New Project</a>
    <?php if($projects): ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Link</th>
                <th>Actions</th>
            </tr>
            <?php foreach($projects as $proj): ?>
            <tr>
                <td><?= htmlspecialchars($proj['title']) ?></td>
                <td><?= htmlspecialchars($proj['description']) ?></td>
                <td>
                    <?php if($proj['link']): ?>
                        <a href="<?= htmlspecialchars($proj['link']) ?>" target="_blank">View</a>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td>
                    <a href="edit.php?type=projects&id=<?= $proj['id'] ?>" class="button">Edit</a>
                    <a href="delete.php?type=projects&id=<?= $proj['id'] ?>" onclick="return confirm('Are you sure you want to delete this project?');" class="button">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No projects added yet.</p>
    <?php endif; ?>
</div>

<a href="logout.php" class="button mt-base">Logout</a>

</body>
</html>
