<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once '../includes/session.php';
include_once '../database/db_msg.php';
include_once '../database/db_user.php';
include_once '../templates/tpl_common.php';
include_once '../templates/tpl_posts.php';

if (!isset($_SESSION['user_id'])) {
    die(header('Location: login.php'));
}

$user_id = $_GET['user_id'];
$user = getUserById($user_id);

$stories = getAllStoriesOfUserWithInfo($user_id);

$categories = getTopChannels();

$username = $user['username'];

draw_head(profile_head());
draw_header($username);
draw_aside($categories);
if ($user_id == $_SESSION['user_id'])
    draw_editable_profile_info($user);
else 
    draw_profile_info($user);
    
draw_stories($stories);
draw_footer();

?>

<?php function draw_profile_info($user) { ?>
    <div class="profile">
    <h1 class="name"> <?=$user['username']?> </h1>
    <img class="image" src="https://is1-ssl.mzstatic.com/image/thumb/Purple71/v4/47/cf/cf/47cfcf79-9e1d-b21f-8e10-2658b7650c15/mzl.oiljceng.png/246x0w.jpg" alt="image">
    </div>
<?php } ?>

<?php function draw_editable_profile_info($user) { ?>
    <div class="profile-editable">
    <h1 class="name"> <?=$user['username']?> </h2>
    <img class="image" src="https://is1-ssl.mzstatic.com/image/thumb/Purple71/v4/47/cf/cf/47cfcf79-9e1d-b21f-8e10-2658b7650c15/mzl.oiljceng.png/246x0w.jpg" alt="image">
    <a class="account-settings" href="../pages/settings.php">Account Settings</a>
    </div>
<?php } ?>



<?php function profile_head() {
  return '
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/variables.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/aside.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/story.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
    
    <script src="../js/utilities.js" defer></script>
    <script src="../js/vote.js" defer></script>
    <script src="../js/post.js" defer></script>
    <script src="../js/infiniteScroll.js" defer></script>
    ';
} ?>