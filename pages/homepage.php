<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once '../includes/session.php';
include_once '../database/db_msg.php';
include_once '../templates/tpl_common.php';
include_once '../templates/tpl_posts.php';

if (!isset($_SESSION['username'])) {
    die(header('Location: login.php'));
}

$stories = getAllStoriesWithInfo();

$categories = getTopChannels();

draw_header($_SESSION['username']);
draw_aside($categories);
draw_stories($stories);
draw_footer();

?>