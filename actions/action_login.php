<?php
  include_once('../includes/session.php');
  include_once('../database/db_user.php');
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (checkUserPassword($username, $password)) {
    $_SESSION['username'] = $username;
    header('Location: ../pages/index.php');
  } else {
    echo "wrong";
    header('Location: ../pages/login.php');
  }
?>