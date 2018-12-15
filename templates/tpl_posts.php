<?php include_once('../database/db_user.php'); ?>

<?php function draw_stories($stories) {?>
<section id="stories">
</section>
<?php } ?>


<?php function draw_post_full($message_id) {?>
  <div class="post_wrap" data-id="<?=$message_id?>">
  </div>
<?php }?>

<?php function draw_comments($message_id) { ?>
<div class="comments_wrap">

  <article class="comments_page">
    <!-- comments -->

    <header class="comments_header">
      <!-- comment_title -->
      Comments
    </header>

    <section class="comment-wrap" data-id=<?=$message_id?>>
      <div class="comment">
      </div>
      <section class="new_comment_area">
      </section>
      <div class="subcomments">
      </div>
    </section>
  </article>
</div>
<?php }
?>