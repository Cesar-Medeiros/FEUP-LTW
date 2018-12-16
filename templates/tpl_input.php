<?php function draw_editable_input($id, $name, $firstValue) {?>
  <li id = 'input' data-type = "editable" data-id=<?=$id?>> 
  <label><?=$name?><span contentEditable="true" data-backup=<?=$firstValue?>><?=$firstValue?></span></label>
  <div id = 'editionTools' hidden>
  <?php draw_edition_buttons();?>
  </div>
  </li>
<?php } ?>

<?php function draw_edition_buttons() {?>
  <div class="buttons">
  <input id="save" type="submit" class="button" value="Save"/>
  <input id="cancel" type="submit" class="button" value="Cancel"/>
</div>
<?php } ?>

<?php function draw_password_input($id, $name, $previous) {?>
  <li id = 'input' data-type = "password" data-id=<?=$id?> data-previous=<?=$previous?>>
  <label><?=$name?></label>
  <div id = 'editionTools' hidden>
    <label id = "old" >Old Password:<input name="old-password" type="password" class="input" required> </label>
    <label id = "new"> New Password:<input name="new-password" type="password" class="input" required> </label>
    <label id = "new-conf">Confirm New Password:<input name="new-password-conf" type="password" class="input" required> </label>
    <?=draw_edition_buttons()?>
  </div>
  </li>
<?php } ?>
