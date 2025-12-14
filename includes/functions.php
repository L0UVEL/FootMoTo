<?php
// Function to clean input data to prevent SQL injection and XSS
// Lilinisin nito yung input para safe sa database
function sanitize_input($data)
{
    $data = trim($data); // Remove extra spaces
    $data = stripslashes($data); // Remove backslashes
    $data = htmlspecialchars($data); // Convert special chars to HTML entities
    return $data;
}

// Helper paramakpag-redirect sa ibang page
// Stops script execution after redirect
function redirect($url)
{
    header("Location: $url");
    exit();
}

// Check kung naka-login si user
// If hindi, redirect sa login page
function check_login()
{
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
}

// Check kung admin ang user
// If hindi admin, ibabalik sa homepage (Security measure)
function check_admin()
{
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        redirect('../index.php');
    }
}
?>
