<?php

function requireLogin() {
  if (!isset($_SESSION['user_id'])) {
    header("Location: /auth/login.php");
    exit;
  }
}


function requireRole($role) {
  if ($_SESSION['role'] !== $role) {
    die("Access denied");
  }
}
?>
