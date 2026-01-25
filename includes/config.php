<?php
date_default_timezone_set('Africa/Cairo');

// Error Reporting & Logging
// Hide errors from the browser (Security)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

// Log errors to a file (Debugging)
ini_set('log_errors', 1);
error_reporting(E_ALL);
// Set the log file path to /logs/error.log in the project root
ini_set('error_log', dirname(__DIR__) . '/logs/error.log');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// // server 
// $host = 'localhost';
// $dbname = 'sccisujk_scci_platform26';
// $username = 'sccisujk_scci_board';
// $password = 'board#SCCI2026';

$localhost = "localhost";
$username = "root";
$password = "";
// $database = "scci_26";
$database = "SCCI";



$connect = mysqli_connect($localhost, $username, $password, $database);

if (isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['user_id']);
    header('location:./auth/login.php');

}
?>