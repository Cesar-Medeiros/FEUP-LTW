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
    $ret = $stmt->fetch();
    
    if($ret == false){
      $ret = array('user_id' => $user_id, 'message_id' => $message_id,  'vote' => 0);
    }
    return $ret;
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
    return intval($db->lastInsertId());
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

 
  function getNextStoriesByTime($last_id, $channel, $author, $user){
    $db = Database::db();
    $stmt = $db->prepare('SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.comments, User.user_id, User.username, Channel.title as channel, Channel.title as val
    FROM Message JOIN ChannelMessages USING(message_id) JOIN Channel USING(channel_id) JOIN USER ON Message.publisher = User.user_id JOIN ChannelSubscribers USING(channel_id)
    WHERE Message.message_id < ? AND Message.parent_message_id is null AND Channel.channel_id LIKE ? AND User.user_id LIKE ? AND ChannelSubscribers.user_id LIKE ?
    ORDER BY message_id DESC LIMIT 5');
    $stmt->execute(array($last_id, $channel, $author, $user));
    return $stmt->fetchAll();
  }

 //ordered by votes


  function getNextStoriesByVotes($last_value, $last_id, $channel, $author, $user){
    $db = Database::db();
    $stmt = $db->prepare("SELECT Message.message_id, Message.title, Message.text, Message.date, Message.score, Message.score as val, Message.comments, User.user_id, User.username, Channel.title as channel
    FROM Message JOIN ChannelMessages USING(message_id) JOIN Channel USING(channel_id) JOIN USER ON Message.publisher = User.user_id JOIN ChannelSubscribers USING(channel_id)
    WHERE Message.parent_message_id is null AND (val < ? OR (val = ? AND message_id < ?)) AND Channel.channel_id LIKE ? AND User.user_id LIKE ? AND ChannelSubscribers.user_id LIKE ?
    ORDER BY val DESC, message_id DESC LIMIT 5;");
    $stmt->execute(array($last_value, $last_value, $last_id, $channel, $author, $user));
    return $stmt->fetchAll();
  }

 //ordered by comments

  function getNextStoriesByComments($last_value, $last_id, $channel, $author, $user){
    $db = Database::db();
    $stmt = $db->prepare("SELECT M1.message_id, M1.title, M1.text, M1.date, M1.score, M1.comments, count(M2.message_id) as val, User.user_id, User.username, Channel.title as channel
    FROM Message M1 JOIN ChannelMessages USING(message_id) JOIN CHANNEL USING(channel_id) LEFT JOIN Message M2 ON M1.message_id = M2.parent_message_id JOIN User ON M1.publisher = User.user_id JOIN ChannelSubscribers USING(channel_id)
    WHERE M1.parent_message_id is null AND Channel.channel_id LIKE :channel AND User.user_id LIKE :user AND ChannelSubscribers.user_id LIKE :sub
    GROUP BY M1.message_id
    HAVING (val < :val OR ((val = :val) AND (M1.message_id < :id)))
    ORDER BY val DESC, M1.message_id DESC LIMIT 5;");
    $stmt->bindParam(':channel', $channel);
    $stmt->bindParam(':user', $author);
    $stmt->bindParam(':val', $last_value, PDO::PARAM_INT);
    $stmt->bindParam(':id', $last_id, PDO::PARAM_INT);
    $stmt->bindParam(':sub', $user);
    $stmt->execute();
    return $stmt->fetchAll();
  
  }
  /*$stmt->bindParam(1, $channel, PDO::PARAM_INT);
    $stmt->bindParam(2, $author, PDO::PARAM_INT);
    $stmt->bindParam(3, $user, PDO::PARAM_INT);
    $stmt->bindParam(4, $last_value, PDO::PARAM_INT);
    $stmt->bindParam(5, $last_value, PDO::PARAM_INT);
    $stmt->bindParam(6, $last_id, PDO::PARAM_INT);*/
?>

