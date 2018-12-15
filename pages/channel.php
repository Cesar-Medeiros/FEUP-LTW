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

draw_head(channel_head());
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

<?php function channel_head(){
  return '
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/variables.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/aside.css">
    <link rel="stylesheet" href="../css/story.css">
    <link rel="stylesheet" href="../css/channel.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
    
    
    <script src="../js/utilities.js" defer></script>
    <script src="../js/vote.js" defer></script>
    <script src="../js/post.js" defer></script>
    <script src="../js/infiniteScroll.js" defer></script>
    <script src="../js/loadPosts.js" defer></script>';
}?>