<?php 
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));
  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>Fare Niente</title>
    <meta charset="utf-8">
    <script src="../scripts/editSettings.js" defer></script>
  </head>

  <header>
    <h1> Account Settings </h1>
  </header>
  <body>
      <ul>
        <li id = "username"> <label> Username: <span contentEditable="true" data-backup=<?="{$_SESSION['username']}"?>><?=$_SESSION['username']?> </span> </label>
        </li>
        <li id = "password">
        <label> Password
        </label>
        </li>
        <li id = "email">
        <label> Email:
        <label><?=$_SESSION['username']?></label>
        </label>
        </li>
      </ul>
  </body>
  <?php
  draw_footer();

?>