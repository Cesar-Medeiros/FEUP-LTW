<?php
  include_once('../includes/session.php');
  include_once('db_msg.php');
  
  
  $channel = $_GET['channel'];
  $user = $_GET['user'];

  $order_by = $_GET['order_by'];
  $last_value = $_GET['last_value'];
  $last_id = $_GET['last_id'];

  $channel_cond = "1";
  if (!($channel === "all")){
    $channel_cond = "Channel.channel_id = {$channel}";
  }
  $user_cond = "1";
  if (!($user === "none")){
    $user_cond = "User.user_id =".$user;
  }


  $return = -1;
  switch($order_by){
    case "time":
    $return = getNextStoriesByTime($last_id, $channel_cond, $user_cond);
    break;

    case "vote":
    $return = getNextStoriesByVotes($last_value, $last_id, $channel_cond, $user_cond);
    break;

    case "comments":
    $return = getNextStoriesByComments($last_value, $last_id, $channel_cond, $user_cond);
    break;
    }
  echo json_encode($return);
?>