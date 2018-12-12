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
    <h1> <?=$user['username']?> </h2>
    <img class="image" src="https://is1-ssl.mzstatic.com/image/thumb/Purple71/v4/47/cf/cf/47cfcf79-9e1d-b21f-8e10-2658b7650c15/mzl.oiljceng.png/246x0w.jpg" alt="image">
    </div>
<?php } ?>

<?php function draw_editable_profile_info($user) { ?>
    <div class="profile">
    <h1> <?=$user['username']?> </h2>
    <img class="image" src="https://is1-ssl.mzstatic.com/image/thumb/Purple71/v4/47/cf/cf/47cfcf79-9e1d-b21f-8e10-2658b7650c15/mzl.oiljceng.png/246x0w.jpg" alt="image">
    <a class="account-settings" href="../pages/settings.php">Account Settings</a>
    </div>
<?php } ?>