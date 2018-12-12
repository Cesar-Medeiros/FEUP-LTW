<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once '../includes/session.php';
include_once '../database/db_msg.php';
include_once '../database/db_channel.php';
include_once '../database/db_user.php';
include_once '../templates/tpl_common.php';
include_once '../templates/tpl_posts.php';

if (!isset($_SESSION['user_id'])) {
    die(header('Location: login.php'));
}

$channel_id = $_GET['id'];
$channel_info = getChannelInfo($channel_id);

$stories = getNextStoriesOfChannelByTime(PHP_INT_MAX, $channel_id);

$categories = getTopChannels();

$username = getUserById($_SESSION['user_id'])['username'];

draw_head();
draw_header($username);
draw_aside($categories);
draw_channel_info($channel_info);
draw_stories($stories);
draw_footer();

?>

<?php function draw_channel_info($channel_info) {?>
    <div class="channel_info">
        <div class="title"><h1><?= $channel_info['title']?> </h1>
        <div class="creator"> by <?=$channel_info['creator']?> </div> </div>
        <a class="button_subscribe"> SUBSCRIBE </a>
        <a class="subscribers" href=""> <?=$channel_info['num_subscribers']?> subscribers </a>
        <div class="posts"> <?=$channel_info['num_posts']?> posts </div>
    </div>
    
   
<?php } ?>