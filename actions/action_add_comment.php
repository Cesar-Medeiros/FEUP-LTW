<?php
  include_once('../includes/session.php');
  include_once('../database/db_msg.php');
  include_once('../database/db_user.php');


  // Verify if user is logged in
  if (!isset($_SESSION['user_id']))
    die(header('Location: ../pages/login.php'));

  $message_id = $_GET['message_id'];
  $text = $_GET['text'];

  addComment($message_id, $_SESSION['user_id'], $text);

  echo json_encode(getUserById($_SESSION['user_id']));
?>
