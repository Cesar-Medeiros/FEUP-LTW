
<?php
  include_once('../includes/session.php');
  include_once('../database/db_msg.php');

  // Verify if user is logged in
  if (!isset($_SESSION['user_id']))
    die(header('Location: ../pages/login.php'));

  $message_id = $_GET['message_id'];
  $new_vote_val = $_GET['value'];

  $user_id = $_SESSION['user_id'];

  $old_vote_val = getVote($user_id, $message_id)['vote'];

  $button;

  if($old_vote_val == $new_vote_val){
    $button = '0';
    deleteVote($user_id, $message_id);
  }
  else{
    addVote($user_id, $message_id, $new_vote_val);
    $button = $new_vote_val;
  }  

  $res = $res = new \stdClass();
  $res->score = getMessage($message_id)['score'];
  $res->button = $button;

  echo json_encode($res);
?>