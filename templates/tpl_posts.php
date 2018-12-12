<?php include_once('../database/db_user.php'); ?>

<?php function draw_stories($stories) {?>
<section id="stories">

  <?php 
    foreach($stories as $story){
        draw_post($story);
      }
  ?>
</section>
<?php } ?>

<?php function draw_post($story) {?>
  <div class="post shrink">
    <?php 
        draw_story($story);
        draw_story_info($story);
        ?>
  </div>
  <?php }
  ?>

  <?php function draw_post_full($story) {?>
  <div class="post">
    <?php 
        draw_story($story);
        draw_story_info($story);
        ?>
  </div>
  <?php }
  ?>

<?php function draw_story($story) { ?>
<article class="story">

  <header>
    <a class="title" href="../pages/post.php?id=<?=$story['message_id']?>"><?=$story['title']?></a>
  </header>

  <div class="content-wrap">
    <p class="text"><?=$story['text']?></p>
    <img class="image" src="https://is1-ssl.mzstatic.com/image/thumb/Purple71/v4/47/cf/cf/47cfcf79-9e1d-b21f-8e10-2658b7650c15/mzl.oiljceng.png/246x0w.jpg" alt="image">
  </div>
 
  <a href=<?="../pages/post.php?id={$story['message_id']}"?> class="readmore">Read more</a>

</article>
<?php } ?>



<?php function draw_story_info($story_info){?>
<aside class="story_info" data-id="<?=$story_info['message_id']?>">

  <div class="channel">
    <?=$story_info['channel'];?> </div>
  <div class="vote">
    <a class="vote_up" data-id="<?=$story_info['message_id']?>" href=""><i class="fas fa-angle-up"></i></a>
    <a class="vote_down" data-id="<?=$story_info['message_id']?>" href=""><i class="fas fa-angle-down"></i></a>
</div>

  <a class="author_info" href=<?="../pages/profile.php?user_id={$story_info['user_id']}"?>>
    <img class="user_img" src="https://cdn4.iconfinder.com/data/icons/web-ui-color/128/Account-512.png" style="height:20px;width:20px;">
    <label class="user_name"> <?=$story_info['username']?>
  </a>
  <div class="score">
    <?=$story_info['score'];?></div>
  <div class="comments">
    <?=$story_info['comments'];?></div>
  <div class="date">
    <?=formatedTime($story_info['date']);?></div>

</aside>
<?php
}?>


<?php function draw_comments($comments, $message_id) { ?>
  <div class="comments_wrap">

    <article class="comments_page"> <!-- comments -->

      <header class="comments_header"> <!-- comment_title -->
        Comments
      </header>
      
      <section class="comment-wrap" data-id=<?=$message_id?>>

      </section>

      <?php draw_new_comment_area($message_id) ?>
    </article>
  </div>
  <?php }
?>



<?php function draw_new_comment_area($message_id) {?>
  <div class="new-comment" data-id = <?=$message_id?>>
    <textarea id="send_text" name="text" placeholder="Write comment..." class="text" required></textarea>
    <a id="send_button" href="">Send</a>
  </div>
<?php } ?>




<?php function formatedTime($datetime) {
  $ago = new DateTime();
  $ago->setTimestamp($datetime);
  $now = new DateTime;
  $diff = $now->diff($ago);

  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  $string = array(
      'y' => 'year',
      'm' => 'month',
      'w' => 'week',
      'd' => 'day',
      'h' => 'hour',
      'i' => 'minute',
      's' => 'second',
  );


  if($diff->y < 0){
    $val = 0;
  }

  else{
    foreach ($string as $k => &$v) {

        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            if($v != 0){
              $val = $v;
              break;
            }

        } else {
            unset($string[$k]);
        }
    }
  }

  return $val ? $val  . ' ago' : 'just now';
}?>