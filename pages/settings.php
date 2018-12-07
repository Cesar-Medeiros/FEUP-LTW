<?php 
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_input.php');
  include_once('../database/db_user.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));

  $user = getUserById($_SESSION['user_id']);
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
        <?php draw_editable_input("username", "Username:", $user['username'])?>
        <?php draw_password_input("password", "Password:", $user['password'])?>
        <?php draw_editable_input("email", "Email:", $user['email'])?>
      </ul>
  </body>
  <?php
  draw_footer();

?>