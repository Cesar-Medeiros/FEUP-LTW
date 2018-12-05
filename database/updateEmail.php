<?php
  /* Receives an email and updates current session with it */

  include_once('../includes/session.php');
  include_once('db_user.php');
  
  $user_id = $_SESSION['user_id'];
  $newEmail = $_GET['email'];

  updateEmail($user_id, $newEmail);

  // JSON encode
  echo json_encode($newEmail);
?>