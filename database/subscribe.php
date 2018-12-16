<?php
  include_once('../includes/session.php');
  include_once('db_channel.php');
  
  $user_id = $_SESSION['user_id'];
  $channel = $_GET['channel'];

  $res = updateSubscription($user_id, $channel);
  echo json_encode($res);
?>