<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/header.php';
?>

<div class="dashboard-container">

    <h1 class="dashboard-header">System Documentation</h1>

    <!-- 1. Overview -->
    <div class="dashboard-card">
        <h2>1. Overview</h2>
        <p>This system allows users to create, view, edit, and manage resumes. 
           Admin users have additional controls for overseeing user accounts.</p>
    </div>

    <!-- 2. Features -->
    <div class="dashboard-card">
        <h2>2. Features</h2>
        <ul >
            <li>User registration and login</li>
            <li>Create and edit resume data</li>
            <li>Upload profile picture and documents</li>
            <li>Admin panel for managing users</li>
            <li>Download/export resume (if implemented)</li>
        </ul>
    </div>

    <!-- 3. Database Tables -->
    <div class="dashboard-card">
        <h2>3. Database Tables</h2>

        <h3>users</h3>
        <p>Stores login credentials and basic user info (username, email, password, role).</p>

        <h3>resume</h3>
        <p>Contains all resume-related details for each user (name, title, contact info, about, avatar, social links).</p>

        <h3>experience</h3>
        <p>Stores past work experiences linked to each resume (company, position, start/end dates, description, location).</p>

        <h3>education</h3>
        <p>Stores educational history linked to each resume (school, degree, start/end years, location, description).</p>

        <h3>skills</h3>
        <p>Stores skills information linked to each resume (skill name, category, level).</p>

        <h3>projects</h3>
        <p>Stores projects linked to each resume (title, description, start/end years, project link).</p>
    </div>

    <!-- 4. User Roles -->
    <div class="dashboard-card">
        <h2>4. User Roles</h2>
        <ul>
            <li><strong>User:</strong> Can manage their own resume, edit information, and view public resume.</li>
            <li><strong>Admin:</strong> Can view and manage all users, edit or delete any resume, and oversee system data.</li>
        </ul>
    </div>

    <!-- 5. How To Use -->
    <div class="dashboard-card">
        <h2>5. How To Use</h2>
        <ol>
            <li>Register an account on the "Register" page.</li>
            <li>Login using your credentials.</li>
            <li>Create or update your resume using the dashboard.</li>
            <li>Add experiences, education, skills, and projects as needed.</li>
            <li>Download or export the resume (if implemented).</li>
        </ol>
    </div>

    <!-- Optional Footer Note -->
    <div class="dashboard-card">
        <h2>6. Notes</h2>
        <p>This system is designed for demonstration purposes. Future enhancements may include additional export formats, PDF generation, and enhanced admin controls.</p>
    </div>

</div>

<?php require_once 'includes/footer.php'; ?>
