<?php
  include_once('../includes/session.php');
  include_once('db_msg.php');
  
  
  $channel = $_GET['channel'];
  $author = $_GET['author'];
  $subscription = $_GET['subs'];

  $order_by = $_GET['order_by'];
  $last_value = $_GET['last_value'];
  $last_id = $_GET['last_id'];


  $return = -1;
  switch($order_by){
    case "time":
    if($subscription === "true")
    $return = getNextSubscribedStoriesByTime($last_id, "{$_SESSION['user_id']}");
    else if ($channel != "all")
    $return = getNextChannelStoriesByTime($last_id,$channel);
    else if ($author != "none")
    $return = getNextPostedStoriesByTime($last_id, $author);
    else $return = getNextStoriesByTime($last_id);

    break;
    case "vote":
    if($subscription === "true")
    $return = getNextSubscribedStoriesByVotes($last_id, "{$_SESSION['user_id']}");
    else if ($channel != "all")
    $return = getNextChannelStoriesByVotes($last_id,$channel);
    else if ($author != "none")
    $return = getNextPostedStoriesByVotes($last_id, $author);
    else $return = getNextStoriesByVotes($last_id);

    break;
    case "comments":
    if($subscription === "true")
    $return = getNextSubscribedStoriesByComments($last_id, "{$_SESSION['user_id']}");
    else if ($channel != "all")
    $return = getNextChannelStoriesByComments($last_id,$channel);
    else if ($author != "none")
    $return = getNextPostedStoriesByComments($last_id, $author);
    else $return = getNextStoriesByComments($last_id);

    break;
    }
  echo json_encode($return);
?>