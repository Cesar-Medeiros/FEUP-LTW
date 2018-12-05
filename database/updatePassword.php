<?php
  /* Receives a password and updates current session with it */

  include_once('../includes/session.php');
  include_once('db_user.php');
  
  $user_id = $_SESSION['user_id'];
  $newPassword = $_GET['password'];

  updatePassword($user_id, $newPassword);

  // JSON encode
  echo json_encode($newPassword);
?>