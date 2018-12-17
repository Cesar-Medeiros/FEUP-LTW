<?php
  include_once('../includes/session.php');
  include_once('../database/db_msg.php');
  include_once('../includes/upload.php');


  // Verify if user is logged in
  if (!isset($_SESSION['user_id']))
    die(header('Location: ../pages/login.php'));


  
  $channel = $_POST['channel'];

  $title = $_POST['title'];
  $text = $_POST['text'];
  $file = $_FILES['file'];

  $message_id = addMessage($_SESSION['user_id'], $title, $text);
  addChannelMessages($channel, $message_id);
  uploadImage($file, 'image', $message_id);
  header('Location: ../pages/homepage.php');
?>
