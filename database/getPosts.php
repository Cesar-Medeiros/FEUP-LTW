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

  $return = -1;
  switch($order_by){
    case "time":
    if($subscription === "false")
    $return = getNextStoriesByTime($last_id, $channel_like, $author_like);
    else $return = getNextSubscribedStoriesByTime($last_id, $channel_like, $author_like, "{$_SESSION['user_id']}");
    break;

    case "vote":
    if ($subscription === "false")
    $return = getNextStoriesByVotes($last_value, $last_id, $channel_like, $author_like);
    else $return = getNextSubscribedStoriesByVotes($last_value, $last_id, $channel_like, $author_like, "{$_SESSION['user_id']}");
    break;

    case "comments":
    if ($subscription === "false")
    $return = getNextStoriesByComments($last_value, $last_id, $channel_like, $author_like);
    else $return = getNextSubscribedStoriesByComments($last_value, $last_id, $channel_like, $author_like, "{$_SESSION['user_id']}");
    break;
    }
  echo json_encode($return);
?>