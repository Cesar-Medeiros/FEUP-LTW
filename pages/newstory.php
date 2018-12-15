<?php
include_once '../includes/session.php';
include_once '../database/db_msg.php';
include_once '../database/db_user.php';
include_once '../templates/tpl_common.php';
include_once '../templates/tpl_posts.php';

if (!isset($_SESSION['user_id'])) {
    die(header('Location: login.php'));
}

$username = getUserById($_SESSION['user_id'])['username'];

draw_head(new_story_head());
draw_header($username);
draw_aside([]);
draw_new_story();
draw_footer();
?>


<?php function draw_new_story(){?>
    <form accept-charset="utf-8" form method="post" class="new-story-form">
        <label for="channel" class="label">Channel</label>
        <input name="channel" maxlength="255" type="text" class="input" value="all" required>

        <label for="title" class="label">Title</label>
        <input name="title" maxlength="255" type="text" class="input" required>

        <label for="text" class="label">Text</label>
        <textarea name="text" placeholder="Write something..." class="text" required></textarea>

    <div class="buttons">
        <input type="submit" class="button send" formaction="../actions/action_new_story.php" value="Post">
        <a class="button cancel" href="../pages/homepage.php">Cancel</a>
    </div>
    </form>
<?php }?>


<?php function new_story_head() {
  return '
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/variables.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/aside.css">
    <link rel="stylesheet" href="../css/newstory.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">';
} ?>

