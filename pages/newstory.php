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

$categories = getTopChannels();

draw_head(new_story_head());
draw_header($username);
draw_aside($categories);
draw_new_story($categories);
draw_footer();
?>


<?php function draw_new_story($categories){?>
    <form accept-charset="utf-8" form method="post" class="new-story-form" enctype="multipart/form-data">
        <label for="channel" class="label">Channel</label>
        <select class="input" name="channel" onchange=''>
            <option value=0>all</option>;
                <?php foreach($categories as $category){?>
                    <option value=<?="{$category['channel_id']}"?>><?=$category['title']?></option>;
                <?php } ?>
        </select>

    <label for="title" class="label">Title</label>
    <input name="title" maxlength="255" type="text" class="input" required>

    <label for="text" class="label">Text</label>
    <textarea name="text" placeholder="Write something..." class="text" required></textarea>

    <div id="upload-container">
        <div id="upload-choose-container">
            <input type="file" id="upload-file" name="file" accept="image/jpeg, image/png" />
            <button id="choose-upload-button"><i class="far fa-image fa-2x"></i></button>
        </div>
        <div id="placeholder">
            <button id="cancel-button"><i class="far fa-times-circle fa-2x"></i></button>
        </div>
        <div id="error-message"></div>
        <div id="img_placeholder"></div>
    </div>

    <div class="buttons">
        <input type="submit" class="button send" formaction="../actions/action_new_story.php" value="Post">
        <a class="button cancel" href="../pages/allPosts.php">Cancel</a>
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
    <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
    <script src="../js/image.js" defer></script>
    ';
} ?>