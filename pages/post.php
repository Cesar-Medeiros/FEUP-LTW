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

draw_head(post_head());
draw_header($username);
draw_aside($categories);
draw_post_full($message_id);
draw_comments($message_id);
draw_footer();

?>


<?php function post_head() {
  return '
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/variables.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/aside.css">
    <link rel="stylesheet" href="../css/story.css">
    <link rel="stylesheet" href="../css/comments.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
    <script src="../js/utilities.js" defer></script>
    <script src="../js/vote.js" defer></script>
    <script src="../js/post.js" defer></script>
    <script src="../js/post_page.js" defer></script>
    <script src="../js/comment.js" defer></script>';
} ?>