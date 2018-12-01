<?php if (isset($_SESSION['messages'])) {?>
  <section id="messages">
    <?php foreach($_SESSION['messages'] as $message) { ?>
      <div class="<?=$message['type']?>"><?=$message['content']?></div>
    <?php } ?>
  </section>
<?php unset($_SESSION['messages']); } ?>