<?php
  include_once('../includes/session.php');
  include_once('db_msg.php');
  
  $user_id = $_SESSION['user_id'];
  $max_id = $_GET['max_id'];
  $channel_id = $_GET['channel_id'];
  $order_by = $_GET['order_by'];
  $max = $_GET['max'];

  $return = -1;
  if ($channel_id === "all"){
    switch($order_by){
      case "time":
      $return = getNextStoriesByTime($max_id);
      break;
      case "vote":
      $return = getNextStoriesByVotes($max, $max_id);
      break;
      case "comments":
      $return = getNextStoriesByComments($max, $max_id);
      break;
    }
  }
  else{
    switch($order_by){
      case "time":
      $return = getNextStoriesOfChannelByTime($max_id, $channel_id);
      break;
      case "vote":
      $return = getNextStoriesOfChannelByVotes($max, $max_id, $channel_id);
      break;
      case "comments":
      $return = getNextStoriesOfChannelByComments($max, $max_id, $channel_id);
      break;
    }
  }
  echo json_encode($return);
?>