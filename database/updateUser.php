<?php
  include_once('../includes/session.php');
  include_once('db_user.php');
  
  $user_id = $_SESSION['user_id'];
  $newUsername = $_GET['username'];
  $newPassword = $_GET['password'];
  $newEmail = $_GET['email'];

  $result = updateUser($user_id, $newUsername, $newPassword, $newEmail);
  echo json_encode($result);
 
?>