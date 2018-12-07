<?php
  include_once('../includes/session.php');
  include_once('../database/db_msg.php');


  // Verify if user is logged in
  if (!isset($_SESSION['username']))
    die(header('Location: ../pages/login.php'));

  $channel = $_POST['channel'];
  $title = $_POST['title'];
  $text = $_POST['text'];

  $message_id = addMessage($_SESSION['user_id'], $title, $text);
  addChannelMessages(1, $message_id);
  header('Location: ../pages/homepage.php');
?>
