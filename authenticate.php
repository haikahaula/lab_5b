<?php
session_start();

include 'Database.php';
include 'User.php';

$error = ''; // Initialize error message

if (isset($_POST['submit']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    // Create database connection
    $database = new Database();
    $db = $database->getConnection();

    // Sanitize inputs
    $matric = $db->real_escape_string(trim($_POST['matric']));
    $password = $db->real_escape_string(trim($_POST['password']));

    // Validate inputs
    if (!empty($matric) && !empty($password)) {
        $user = new User($db);
        $userDetails = $user->getUser($matric);

        // Check if user exists and verify password
        if ($userDetails && password_verify($password, $userDetails['password'])) {
            // Double-check user still exists
            if ($user->getUser($userDetails['matric'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['matric'] = $userDetails['matric'];
                $_SESSION['name'] = $userDetails['name'];
                $_SESSION['role'] = $userDetails['role'];

                // Redirect to dashboard
                header('Location: read.php');
                exit;
            } else {
                $error = "User account no longer exists.";
            }
        } else {
            $error = "Invalid matric or password. <a href='login.php'>Try login again</a>";
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>