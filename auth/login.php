<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // check db
  // set session
  header("Location: /profile/");
}
?>

<form method="POST">
  <input name="email">
  <input type="password" name="password">
  <button>Login</button>
</form>
<!-- test -->
