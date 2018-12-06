<?php
include_once '../includes/session.php';
include_once '../database/db_msg.php';
include_once '../templates/tpl_common.php';
include_once '../templates/tpl_posts.php';

if (!isset($_SESSION['username'])) {
    die(header('Location: login.php'));
}

draw_header($_SESSION['username']);
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
<?php
}?>