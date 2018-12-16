<?php function draw_editable_input($id, $name, $firstValue) {?>
  <li id = 'input' data-type = "editable" data-selected = false data-id=<?=$id?>> 
  <div class='edit'><?=$name?><span contentEditable="true" data-backup=<?=$firstValue?>><?=$firstValue?></span></div>
  <div id = 'editionTools' hidden>
  <?php draw_edition_buttons();?>
  </div>
  </li>
<?php } ?>

<?php function draw_edition_buttons() {?>
  <div class="buttons">
  <input id="save" class="button" type="submit" class="button" value="Save"/>
  <input id="cancel" class="button" type="submit" class="button" value="Cancel"/>
</div>
<?php } ?>

<?php function draw_password_input($id, $name, $previous) {?>
  <li id = 'input' data-type = "password" data-selected = false data-id=<?=$id?> data-previous=<?=$previous?>>
  <div class='edit'><?=$name?></div>
  <div id = 'editionTools' hidden>
    <label id = "old" >Old Password:<input name="old-password" type="password" class="input" required> </label>
    <label id = "new"> New Password:<input name="new-password" type="password" class="input" required> </label>
    <label id = "new-conf">Confirm New Password:<input name="new-password-conf" type="password" class="input" required> </label>
    <?=draw_edition_buttons()?>
  </div>
  </li>
<?php } ?>
