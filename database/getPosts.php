<?php
  include_once('../includes/session.php');
  include_once('db_msg.php');
  
  
  $channel = $_GET['channel'];
  $user = $_GET['user'];

  $order_by = $_GET['order_by'];
  $last_value = $_GET['last_value'];
  $last_id = $_GET['last_id'];

  $channel_like = '%';
  
  if (!($channel === "all")){
    $channel_like = $channel;
  }

  $user_like = '%';
  
  if (!($user === "none")){
    $user_like = $user;
  }


  $return = -1;
  switch($order_by){
    case "time":
    $return = getNextStoriesByTime($last_id, $channel_like, $user_like);
    break;

    case "vote":
    $return = getNextStoriesByVotes($last_value, $last_id, $channel_like, $user_like);
    break;

    case "comments":
    $return = getNextStoriesByComments($last_value, $last_id, $channel_like, $user_like);
    break;
    }
  echo json_encode($return);
?>