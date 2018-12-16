<?php
  include_once('../includes/database.php');
  
  function getChannelInfo($channel_id){
    return getChannelSpecs($channel_id);

  }
  function getChannelNumSubscribers($channel_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT num_subscribers FROM Channel WHERE Channel.channel_id = ?');
    $stmt->execute(array($channel_id));
    return $stmt->fetch();
  }

  function getChannelNumMessages($channel_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT num_posts FROM Channel WHERE Channel.channel_id = ?');
    $stmt->execute(array($channel_id));
    return $stmt->fetch();
  }

  function getChannelSpecs($channel_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT title, num_subscribers, num_posts, User.username as creator from Channel, User WHERE channel_id = ? and Channel.creator_id = User.user_id');
    $stmt->execute(array($channel_id));
    return $stmt->fetch();
  }

  function updateSubscription($user_id, $channel_id){
    $db = Database::db();
    try {
      $stmt = $db->prepare('INSERT INTO ChannelSubscribers VALUES(?, ?)');
      $stmt->execute(array($channel_id, $user_id));
    } catch (PDOException $e) {
      $stmt = $db->prepare('DELETE FROM ChannelSubscribers WHERE user_id = ? AND channel_id = ?');
      $stmt->execute(array($user_id, $channel_id));
    }
    return getChannelNumSubscribers($channel_id);
  }

  function isUserSubscribed($user_id, $channel_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT * FROM ChannelSubscribers WHERE user_id = ? AND channel_id = ?');
    $stmt->execute(array($user_id, $channel_id));
    return ($stmt->fetch()? true : false); 
  }
?>