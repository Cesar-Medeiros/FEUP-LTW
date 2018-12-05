<?php
  include_once('../includes/session.php');
  include_once('db_user.php');
  
  $user_id = $_SESSION['user_id'];
  $newUsername = $_GET['username'];

  updateUsername($user_id, $newUsername);
  $_SESSION['username'] = $newUsername;

  // JSON encode
  echo json_encode($newUsername);
?>