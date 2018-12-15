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

$stories = getNextStoriesByTime(PHP_INT_MAX);

$categories = getTopChannels();

$username = getUserById($_SESSION['user_id'])['username'];

draw_head_homepage();
draw_header($username);
draw_aside($categories);
draw_stories($stories);
draw_footer();
?>

<?php function draw_head_homepage() { ?>

<!DOCTYPE html>
<html>

<head>
  <title>Website Name</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/homepage.css">
  <link rel="stylesheet" href="../css/channel.css">
  <link rel="stylesheet" href="../css/settings.css">
  <link rel="stylesheet" href="../css/profile.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
  <script src="../js/utilities.js" defer></script>
  <script src="../js/vote.js" defer></script>
  <script src="../js/post.js" defer></script>
  <script src="../js/infiniteScroll.js" defer></script>
</head>

<?php } ?>