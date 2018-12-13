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

  function getChannelMessagesWithInfo($channel_id) {
    $db = Database::db();
    $stmt = $db->prepare('SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.user_id, User.username, Channel.title as channel
    FROM ChannelMessages JOIN Message USING(message_id), USER, CHANNEL WHERE Channel.channel_id = ? and Message.publisher = User.user_id AND Channel.channel_id = ChannelMessages.channel_id');
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

  function getCommentsWithInfo($message_id) {
    $db = Database::db();
    $stmt = $db->prepare('
      SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.username
      FROM Message, User
      ON Message.publisher = User.user_id
      WHERE parent_message_id = ?');
    $stmt->execute(array($message_id));
    return $stmt->fetchAll(); 
  }


  function getCommentWithInfo($message_id){
    $db = Database::db();
    $stmt = $db->prepare('
      SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.username
      FROM Message, User
      ON Message.publisher = User.user_id
      WHERE message_id = ?');
    $stmt->execute(array($message_id));
    return $stmt->fetch(); 
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
    $stmt = $db->prepare('SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.user_id, User.username, Channel.title as channel
      FROM Message, User, ChannelMessages, Channel
      ON Message.publisher = User.user_id AND Message.message_id = ChannelMessages.message_id AND ChannelMessages.channel_id = Channel.channel_id
      WHERE parent_message_id is null');
    $stmt->execute();
    return $stmt->fetchAll(); 
  }

  function getAllStoriesOfUserWithInfo($user_id) {
    $db = Database::db();
    $stmt = $db->prepare('SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.user_id, User.username, Channel.title as channel
    FROM Message JOIN ChannelMessages USING(message_id) JOIN Channel USING(channel_id), User
    WHERE Message.publisher = User.user_id AND parent_message_id is null and publisher is ?');
    $stmt->execute(array($user_id));
    return $stmt->fetchAll(); 
  }

  function getMessageWithInfo($message_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.user_id, User.username, Channel.title as channel
    FROM Message JOIN ChannelMessages USING(message_id) JOIN Channel USING(channel_id), User
    WHERE Message.publisher = User.user_id AND parent_message_id is null AND message_id = ?');
    $stmt->execute(array($message_id));
    return $stmt->fetch(); 
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

  function addChannelMessages($channel_id, $message_id) {
    $db = Database::db();
    $stmt = $db->prepare('INSERT INTO ChannelMessages VALUES(?, ?)');
    $stmt->execute(array($channel_id, $message_id));
  }


  //Fazer trigger para aumentar o numero de comentários da message anterior
  /**
   * Inserts a new comment to a Message.
   */
  function addComment($message_id, $user_id, $text) {
    $date = time();
    $db = Database::db();
    $stmt = $db->prepare('INSERT INTO Message VALUES(NULL, NULL, ?, ?, ?, ?, ?, ?)');
    $stmt->execute(array($text, $date, 0, 0, $user_id, $message_id));
  }


  /**
   * Inserts a new vote
   */
  function addVote($user_id, $message_id, $vote_value) {
      $db = Database::db();
      /*ON CONFLICT(user_id, message_id) ROLLBACK  UPDATE SET vote = ?*/
      $stmt = $db->prepare('INSERT INTO Vote VALUES (?, ?, ?)');
      $ret = $stmt->execute(array($user_id, $message_id, $vote_value));
      if (!$ret){
        $stmt = $db->prepare('UPDATE Vote SET vote = ? WHERE user_id = ? AND message_id == ? ');
        $stmt->execute(array($user_id, $message_id, $vote_value));
      }
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

  //ordered by time

  //ordered by votes
  function getNextStoriesByTime($max_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.user_id, User.username, Channel.title as channel
    FROM Message JOIN ChannelMessages USING(message_id) JOIN Channel USING(channel_id), USER
    WHERE Message.publisher = User.user_id AND Message.message_id < ? 
    ORDER BY Message.message_id DESC LIMIT 5');
    $stmt->execute(array($max_id));
    return $stmt->fetchAll();
  }

  function getNextStoriesOfChannelByTime($max_id, $channel_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.user_id, User.username, Channel.title as channel
    FROM Message JOIN ChannelMessages USING(message_id) JOIN Channel USING(channel_id), USER
    WHERE Channel.channel_id = ? AND Message.publisher = User.user_id AND Message.message_id < ? 
    ORDER BY Message.message_id DESC 
    LIMIT 5');
    $stmt->execute(array($channel_id, $max_id));
    return $stmt->fetchAll();
  }

  function getNextStoriesByVotes($max_votes, $max_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT * FROM (SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.user_id, User.username, Channel.title as channel, count(*) n_votes
    FROM Message JOIN ChannelMessages USING(message_id) JOIN Channel USING(channel_id) LEFT JOIN Vote ON Vote.message_id = Message.message_id, USER
    WHERE Message.publisher = User.user_id
    GROUP BY Message.message_id)
    WHERE (n_votes < ? OR (n_votes = ? AND message_id < ?))
    ORDER BY n_votes DESC, message_id DESC, message_id DESC LIMIT 5;');
    $stmt->execute(array($max_votes, $max_votes, $max_id));
    return $stmt->fetchAll();
  }

  function getNextStoriesOfChannelByVotes($max_votes, $max_id, $channel_id){
    $db = Database::db();
    $stmt = $db->prepare('SELECT * FROM (SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.user_id, User.username, Channel.title as channel, count(*) n_votes
    FROM Message JOIN ChannelMessages USING(message_id) JOIN Channel USING(channel_id) LEFT JOIN Vote ON Vote.message_id = Message.message_id, USER 
    WHERE Message.publisher = User.user_id AND Channel.channel_id = ?
    GROUP BY Message.message_id)
    WHERE (n_votes < ? OR (n_votes = ? AND Message.message_id < ?))
    ORDER BY n_votes DESC, message_id DESC, Message.message_id DESC LIMIT 5;');
    $stmt->execute(array($channel_id, $max_votes, $max_votes, $max_id));
    return $stmt->fetchAll();
  }
?>