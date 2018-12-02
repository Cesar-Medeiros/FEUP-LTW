<?php function draw_stories($stories) {?>
  <section id="stories">

  <?php 
    foreach($stories as $story)
        draw_story($story);
  ?>
  </section>
<?php } ?>

<?php function draw_story($story) { ?>
  <article class="story">
    <header><h2><?=$story['text']?></h2></header>
  </article>
<?php } ?>