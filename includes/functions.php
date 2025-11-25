<?php
// Validate username (letters, numbers, -, _, min 4 chars)
function validate_username($username, $field_name = "Username") {
    $username = trim($username);
    if (empty($username)) return "$field_name cannot be empty.";
    if (strlen($username) < 4) return "$field_name must be at least 4 characters long.";
    if (!preg_match("/^[a-zA-Z0-9_-]+$/", $username)) {
        return "$field_name can only contain letters, numbers, hyphens, and underscores.";
    }
    return true; // valid
}

// Validate password (min 8 chars, 1 upper, 1 lower, 1 number)
function validate_password($password, $min_length = 8) {
    $password = trim($password);
    if (empty($password)) return "Password cannot be empty.";
    if (strlen($password) < $min_length) return "Password must be at least $min_length characters long.";
    if (!preg_match("/[A-Z]/", $password)) return "Password must contain at least one uppercase letter.";
    if (!preg_match("/[a-z]/", $password)) return "Password must contain at least one lowercase letter.";
    if (!preg_match("/[0-9]/", $password)) return "Password must contain at least one number.";
    return true; // valid
}

// Validate name (letters, spaces, hyphens, apostrophes, min 2 chars)
function validate_name($name, $field_name = "Name") {
    $name = trim($name);
    if (empty($name)) return "$field_name cannot be empty.";
    if (strlen($name) < 2) return "$field_name must be at least 2 characters long.";
    if (!preg_match("/^[a-zA-Z\s'-]+$/", $name)) return "$field_name contains invalid characters.";
    return true; // valid
}
?>
