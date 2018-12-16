<?php 
  include_once('../includes/session.php');
  include_once('../database/db_user.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_input.php');
  include_once('../database/db_msg.php');

  if (!isset($_SESSION['user_id']))
    die(header('Location: login.php'));

  $user = getUserById($_SESSION['user_id']);

  $categories = getTopChannels();
  
  draw_head(settings_head());
  draw_header(getUserById($_SESSION['user_id'])['username']);
  draw_account_settings($user);
  draw_aside($categories);
  draw_footer();
?>


<?php function draw_account_settings($user){ ?>
  <body>
  <div class="account_settings"> 
    <h1 class="title"> Account Settings </h1>
      <ul>
        <?php draw_editable_input("username", "Username:", $user['username'])?>
        <?php draw_password_input("password", "Password", $user['password'])?>
        <?php draw_editable_input("email", "Email:", $user['email'])?>
      </ul>
</div>
  </body>
<?php }?>

<?php function settings_head() {
  return '
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/variables.css">
  <link rel="stylesheet" href="../css/nav.css">
  <link rel="stylesheet" href="../css/aside.css">
  <link rel="stylesheet" href="../css/story.css">
  <link rel="stylesheet" href="../css/settings.css">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
    
  <script src="../js/editSettings.js" defer></script>';


} ?>