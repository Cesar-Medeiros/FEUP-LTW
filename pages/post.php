<?php
include_once '../includes/session.php';
include_once '../database/db_msg.php';
include_once '../database/db_user.php';
include_once '../templates/tpl_common.php';
include_once '../templates/tpl_posts.php';

if (!isset($_SESSION['user_id'])) {
    die(header('Location: login.php'));
}

$categories = getTopChannels();

$message_id = $_GET['id'];
$message = getMessageWithInfo($message_id);
$comments = getComments($message_id);

$username = getUserById($_SESSION['user_id'])['username'];

draw_header($username);
draw_aside($categories);
draw_post_full($message);
draw_comments($comments, $message_id);
draw_footer();
?>