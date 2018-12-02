<?php 
  include_once('../includes/session.php');
  include_once('../database/db_msg.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_posts.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));
  $messages = getAllMessages();

  draw_header($_SESSION['username']);
  draw_stories($messages);
  draw_footer();
