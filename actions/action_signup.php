<?php
  include_once('../includes/session.php');
  include_once('../database/db_user.php');
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  try {
    addUser($username, $password);
    $_SESSION['username'] = $username;
    header('Location: ../pages/index.php');
  } catch (PDOException $e) {
    echo "wrong";
    header('Location: ../index.php');
  }

?>