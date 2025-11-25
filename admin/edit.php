<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: ../users/login.php");
    exit;
}

$type = $_GET['type'] ?? '';
$id   = intval($_GET['id'] ?? 0);

if(!$id || !$type){
    header("Location: dashboard.php");
    exit;
}

$error = [];
$success = '';

// Fetch existing entry
if($type == 'experience'){
    $stmt = $pdo->prepare("SELECT * FROM experience WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $entry = $stmt->fetch();
    if(!$entry){
        header("Location: dashboard.php");
        exit;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($type == 'experience'){
        $job_title    = sanitize_input($_POST['job_title']);
        $company_name = sanitize_input($_POST['company_name']);
        $start_year   = intval($_POST['start_year']);
        $end_year     = intval($_POST['end_year']);
        $description  = sanitize_input($_POST['description']);

        // Validation
        if(empty($job_title)) $error[] = "Job title is required.";
        if(empty($company_name)) $error[] = "Company name is required.";
        if(empty($start_year)) $error[] = "Start year is required.";

        if(empty($error)){
            $stmt = $pdo->prepare("UPDATE experience SET job_title = :job, company_name = :company, start_year = :start, end_year = :end, description = :desc WHERE id = :id");
            $stmt->execute([
                'job'     => $job_title,
                'company' => $company_name,
                'start'   => $start_year,
                'end'     => $end_year ?: null,
                'desc'    => $description,
                'id'      => $id
            ]);
            $success = "Experience updated successfully.";

            // Refresh entry after update
            $entry = [
                'job_title' => $job_title,
                'company_name' => $company_name,
                'start_year' => $start_year,
                'end_year' => $end_year,
                'description' => $description
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit <?= ucfirst($type) ?></title>
<link rel="stylesheet" href="css/style.css">
</head>
<body class="p-base">

<h1 class="text-heading">Edit <?= ucfirst($type) ?></h1>

<?php if(!empty($error)): ?>
    <div class="card text-secondary">
        <?php foreach($error as $err) echo "<p>$err</p>"; ?>
    </div>
<?php endif; ?>

<?php if($success): ?>
    <div class="card text-primary">
        <p><?= $success ?></p>
    </div>
<?php endif; ?>

<?php if($type == 'experience'): ?>
<form action="" method="POST" class="section">
    <input type="text" name="job_title" placeholder="Job Title" value="<?= htmlspecialchars($entry['job_title']) ?>" required><br>
    <input type="text" name="company_name" placeholder="Company Name" value="<?= htmlspecialchars($entry['company_name']) ?>" required><br>
    <input type="number" name="start_year" placeholder="Start Year" value="<?= htmlspecialchars($entry['start_year']) ?>" required><br>
    <input type="number" name="end_year" placeholder="End Year (Optional)" value="<?= htmlspecialchars($entry['end_year']) ?>"><br>
    <textarea name="description" placeholder="Description"><?= htmlspecialchars($entry['description']) ?></textarea><br>
    <button type="submit" class="button">Update Experience</button>
</form>
<?php endif; ?>

<a href="dashboard.php" class="button mt-base">Back to Dashboard</a>

</body>
</html>
