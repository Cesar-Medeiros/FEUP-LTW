<?php
  include_once('../includes/session.php');
  include_once('db_msg.php');
  
  
  $channel = $_GET['channel'];
  $author = $_GET['author'];
  $subscription = $_GET['subs'];

  $order_by = $_GET['order_by'];
  $last_value = $_GET['last_value'];
  $last_id = $_GET['last_id'];

  $channel_like = "%";
  
  if (!($channel === "all")){
    $channel_like = "{$channel}";
  }

  $author_like = "%";
  
  if (!($author === "none")){
    $author_like = "{$author}";
  }

  $subscription_like = "%";
  
  if ($subscription=="true"){
    $subscription_like = "{$_SESSION['user_id']}";
  }


  $return = -1;
  switch($order_by){
    case "time":
    $return = getNextStoriesByTime($last_id, $channel_like, $author_like, $subscription_like);
    break;

    case "vote":
    $return = getNextStoriesByVotes($last_value, $last_id, $channel_like, $author_like, $subscription_like);
    break;

    case "comments":
    $return = getNextStoriesByComments($last_value, $last_id, $channel_like, $author_like, $subscription_like);
    break;
    }
  echo json_encode($return);
?>