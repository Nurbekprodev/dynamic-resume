<?php
session_start();
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: ../users/login.php");
    exit;
}

$type = $_GET['type'] ?? '';
$error = [];
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Example for experience
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
            $stmt = $pdo->prepare("INSERT INTO experience (position, company, start_year, end_year, description) VALUES (:job, :company, :start, :end, :desc)");
            $stmt->execute([
                'job'     => $job_title,
                'company' => $company_name,
                'start'   => $start_year,
                'end'     => $end_year ?: null,
                'desc'    => $description
            ]);
            $success = "Experience added successfully.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Entry</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body class="p-base">

<h1 class="text-heading">Add New <?= ucfirst($type) ?></h1>

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
    <input type="text" name="job_title" placeholder="Job Title" required><br>
    <input type="text" name="company_name" placeholder="Company Name" required><br>
    <input type="number" name="start_year" placeholder="Start Year" required><br>
    <input type="number" name="end_year" placeholder="End Year (Optional)"><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <button type="submit" class="button">Add Experience</button>
</form>
<?php endif; ?>

<a href="dashboard.php" class="button mt-base">Back to Dashboard</a>

</body>
</html>
