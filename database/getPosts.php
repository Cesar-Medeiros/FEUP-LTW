<?php
  include_once('../includes/session.php');
  include_once('db_msg.php');
  
  $user_id = $_SESSION['user_id'];
  $min_id = $_GET['min_id'];
  $channel_id = $_GET['channel_id'];

  $return = -1;
  if ($channel_id == 'all'){
    $return = getNextStoriesByTime($min_id);
  }
  else $return = getNextStoriesOfChannelByTime($min_id, $channel_id);
  
  echo json_encode($return);
?>