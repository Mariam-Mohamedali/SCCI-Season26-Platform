<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$localhost = "localhost";
$username = "root";
$password = "";
$database = "SCCI";


$connect = mysqli_connect($localhost, $username, $password, $database);

if (isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['user_id']);
    header('location:./auth/login.php');

}
?>