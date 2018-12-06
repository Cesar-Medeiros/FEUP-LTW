<?php
  include_once('../includes/database.php');

  /**
   * Returns the lists of all messages.
   */
  function getAllStories() {
    $db = Database::db();
    $stmt = $db->prepare('SELECT * FROM Message WHERE parent_message_id is null');
    $stmt->execute();
    return $stmt->fetchAll(); 
  }

  /**
   * Returns top channels
   */
  function getTopChannels(){
    $db = Database::db();
    $stmt = $db->prepare('SELECT * FROM Channel limit 5');
    $stmt->execute();
    return $stmt->fetchAll();    
  }

  /**
   * Returns the list of message of one category
   */
  function getChannelMessages($channel_id) {
    $db = Database::db();
    $stmt = $db->prepare('SELECT * FROM ChannelMessages WHERE channel_id = ?');
    $stmt->execute(array($channel_id));
    return $stmt->fetchAll(); 
  }

/**
   * Returns the list of message of one category
   */
  function getComments($message_id) {
    $db = Database::db();
    $stmt = $db->prepare('SELECT * FROM Message WHERE parent_message_id = ?');
    $stmt->execute(array($message_id));
    return $stmt->fetchAll(); 
  }



  /**
   * Return vote value of a user to a message
   */
  function getVote($user_id, $message_id) {
    $db = Database::db();
    $stmt = $db->prepare('SELECT * FROM Vote WHERE user_id=? AND message_id=?');
    $stmt->execute(array($user_id, $message_id));
    return $stmt->fetch();
  }

  function getAllStoriesWithInfo() {
    $db = Database::db();
    $stmt = $db->prepare('
      SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.username, Channel.title as channel
      FROM Message, User, ChannelMessages, Channel
      ON Message.publisher = User.user_id AND Message.message_id = ChannelMessages.story_id AND ChannelMessages.channel_id = Channel.channel_id
      WHERE parent_message_id is null');
    $stmt->execute();
    return $stmt->fetchAll(); 
  }


  function getMessage($message_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT * FROM Message WHERE message_id = ?');
    $stmt->execute(array($message_id));
    return $stmt->fetch(); 
  }

  /**
   * Inserts a new post
   */
  function addMessage($user_id, $title, $text) {
    $date = time();
    $db = Database::db();
    $stmt = $db->prepare('INSERT INTO Message VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute(array($title, $text, $date, 0, 0, $user_id, NULL));
    return intval($db->lastInsertId());
  }

  function addChannelMessages($channel_id, $story_id) {
    $db = Database::db();
    $stmt = $db->prepare('INSERT INTO ChannelMessages VALUES(?, ?)');
    $stmt->execute(array($channel_id, $story_id));
  }


  //Fazer trigger para aumentar o numero de comentários da message anterior
  /**
   * Inserts a new comment to a Message.
   */
  function addComment($message_id, $user_id, $text) {
    $date = time();
    $db = Database::db();
    $stmt = $db->prepare('INSERT INTO Message VALUES(NULL, ?, ?, ?, ?, ?, ?)');
    $stmt->execute(array($text, $date, 0, 0, $user_id, $message_id));
  }


  /**
   * Inserts a new vote
   */
  function addVote($user_id, $message_id, $vote_value) {
      $db = Database::db();
      $stmt = $db->prepare('INSERT INTO Vote VALUES (?, ?, ?) ON CONFLICT(user_id, message_id) DO UPDATE SET vote = ?');
      $stmt->execute(array($user_id, $message_id, $vote_value, $vote_value));
    }

  /**
   * Deletes vote.
   */
  function deleteVote($user_id, $message_id) {
    $db = Database::db();
    $stmt = $db->prepare('DELETE FROM Vote WHERE user_id = ? AND message_id = ?');
    $stmt->execute(array($user_id, $message_id));
  }

  function deleteMessage($message_id){
    $db = Database::db();
    $stmt = $db->prepare('DELETE FROM Message WHERE message_id = ?');
    $stmt->execute(array($message_id));
  }

?>