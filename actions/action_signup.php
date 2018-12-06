<?php
  include_once('../includes/session.php');
  include_once('../database/db_user.php');
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  try {
    addUser($username, $password);
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = getUser($username)['user_id'];
    header('Location: ../pages/homepage.php');
  } catch (PDOException $e) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to signup!');
    header('Location: ../pages/login.php');
  }
?>