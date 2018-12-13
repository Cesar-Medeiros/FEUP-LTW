<?php 
  include_once('../includes/session.php');
  include_once('../database/db_user.php');
  include_once('../database/db_msg.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_input.php');

  if (!isset($_SESSION['user_id']))
    die(header('Location: login.php'));

  $user = getUserById($_SESSION['user_id']);
  $categories = getTopChannels();

  draw_header(getUserById($_SESSION['user_id'])['username']);
  draw_aside($categories);?>
  <body>
  <h1 class="account_settings"> Account Settings </h1>
      <ul>
        <?php draw_editable_input("username", "Username:", $user['username'])?>
        <?php draw_password_input("password", "Password:", $user['password'])?>
        <?php draw_editable_input("email", "Email:", $user['email'])?>
      </ul>
  </body>
  <?php
  draw_footer();

?>