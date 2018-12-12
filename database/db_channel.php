<?php
  include_once('../includes/database.php');
  
  function getChannelInfo($channel_id){
    return getChannelSpecs($channel_id);

  }
  function getChannelNumSubscribers($channel_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT count(user_id) as num from ChannelSubscribers WHERE channel_id = ?');
    $stmt->execute(array($channel_id));
    return $stmt->fetch();
  }

  function getChannelNumMessages($channel_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT count(message_id) as num from ChannelMessages WHERE channel_id = ?');
    $stmt->execute(array($channel_id));
    return $stmt->fetch();
  }

  function getChannelSpecs($channel_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT title, num_subscribers, num_posts, User.username as creator from Channel, User WHERE channel_id = ? and Channel.creator_id = User.user_id');
    $stmt->execute(array($channel_id));
    return $stmt->fetch();
  }
?>