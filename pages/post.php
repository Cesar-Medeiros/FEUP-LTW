<?php
include_once '../includes/session.php';
include_once '../database/db_msg.php';
include_once '../templates/tpl_common.php';
include_once '../templates/tpl_posts.php';

if (!isset($_SESSION['username'])) {
    die(header('Location: login.php'));
}

$categories = getTopChannels();

$message_id = $_GET['id'];
$message = getStoryWithInfo($message_id);
$comments = getComments($message_id);

draw_header($_SESSION['username']);
draw_aside($categories);
draw_post($message);
draw_comments($comments);
draw_footer();

?>