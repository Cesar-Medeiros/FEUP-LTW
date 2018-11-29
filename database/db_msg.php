<?php
  include_once('../includes/database.php');

  /**
   * Returns the lists of all messages.
   */
  function getAllMessages() {
    $db = Database::db();
    $stmt = $db->prepare('SELECT * FROM Message');
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
    $stmt = $db->prepare('SELECT FROM Vote WHERE user_id=? AND message_id=?');
    $stmt->execute(array($user_id, $message_id));
    return $stmt->fetch();
  }


  /**
   * Inserts a new post
   */
  function addMessage($user_id, $text) {
    $date = time();
    $db = Database::db();
    $stmt = $db->prepare('INSERT INTO Message VALUES(NULL, ?, ?, ?, ?, ?, ?)');
    $stmt->execute(array($text, $date, 0, 0, $user_id, NULL));
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
    $voteValue = getVote($user_id, $message_id);
    if($voteValue !== null){
      deleteVote($user_id, $message_id);
    }
    $stmt = $db->prepare('INSERT INTO Message VALUES(?, ?, ?)');
    $stmt->execute(array($user_id, $message_id, $vote_value));
  }


  /**
   * Deletes vote.
   */
  function deleteVote($user_id, $message_id) {
    $db = Database::db();
    $stmt = $db->prepare('DELETE FROM Vote WHERE user_id = ? AND message_id = ?');
    $stmt->execute(array($user_id, $message_id));
  }

?>