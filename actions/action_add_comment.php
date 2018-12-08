<?php
  include_once('../includes/session.php');
  include_once('../database/db_msg.php');


  // Verify if user is logged in
  if (!isset($_SESSION['user_id']))
    die(header('Location: ../pages/login.php'));

  $message_id = $_POST['message_id'];
  $text = $_POST['text'];

  addComment($message_id, $_SESSION['user_id'], $text);


  $res = new \stdClass();
  $res->content = $text;

  echo json_encode($res);
?>
