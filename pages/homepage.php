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

$stories = getNextStoriesByTime(PHP_INT_MAX, -1);

$categories = getTopChannels();

$username = getUserById($_SESSION['user_id'])['username'];

draw_header($username);
draw_aside($categories);
draw_stories($stories);
draw_footer();

?>