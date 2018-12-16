<?php function draw_head($options) { 
/**
 * Draws the header for all pages. Receives an username
 * if the user is logged in in order to draw the logout
 * link.
 */?>
<!DOCTYPE html>
<html>

<head>
  <title>Post-it</title>
  <meta charset="utf-8">
  <?=$options;?>
</head>

<?php } ?>

<?php function draw_header($username) { 
/**
 * Draws the header for all pages. Receives an username
 * if the user is logged in in order to draw the logout
 * link.
 */ 
?>
<body>
<header class="navbar">
  <ul id="navbar-menu">
    <li class="navbar-left-wrap">
      <a class="gn-icon username" href=<?= "../pages/profile.php?user_id={$_SESSION['user_id']}"?>><i class="fas fa-user-circle fa-2x"></i>
        <?=$username;?></a>
      <a class="gn-icon settings" href="../pages/settings.php"><i class="fas fa-cog"></i></a>
      <a class="gn-icon logout" href="../actions/action_logout.php"><i class="fas fa-power-off"></i></a>
    </li>
    <li class="navbar-center-wrap"><a class="gn-icon logo" href="../pages/homepage.php">Post-it</a></li>
    <li class="navbar-right-wrap">
      <select id="sort_by" onchange='setOrderSetting(this.value)'>
        <option value="time">Most recent</option>
        <option value="vote">Most voted up</option>
        <option value="comments">Most commented</option>
      </select>
      <span class="search-bar-item">
        <input placeholder="Search..." type="search" class="gn-search">
        <a class="gn-icon gn-icon-search"></a>
      </span>
    </li>
  </ul>
</header>
<?php } ?>

<?php function draw_footer() { 
/**
 * Draws the footer for all pages.
 */ ?>
  </body>

  </html>
<?php }?>


<?php function draw_aside($channels){?>
  <aside class="sidebar">
    <nav class="gn-menu-wrapper gn-open-part">
      <div class="gn-scroller">
        <ul id="gn-menu" class="gn-menu-main">
        <li>
         <a class="gn-icon gn-icon-download" href="../pages/allPosts.php">all</a>
        </li>
          <?php 
            foreach($channels as $channel)
              draw_aside_channel($channel);
          ?>
          <li><a class="new_story_button" href="../pages/newstory.php"><i class="fas fa-plus-circle"> New Story</i></a>
          <li>
        </ul>
      </div>
    </nav>
  </aside>
<?php }?>


<?php function draw_aside_channel($channel){?>
  <li>
    <a class="gn-icon gn-icon-download" href="../pages/channel.php?id=<?=$channel['channel_id']?>">
      <?=$channel['title']?></a>
  </li>
<?php }?>


<?php
/*
<aside>
    <nav class="gn-menu-wrapper gn-open-part">
      <div class="gn-scroller">
        <ul id="gn-menu" class="gn-menu-main">

          <li class="gn-search-item">
            <input placeholder="Search" type="search" class="gn-search">
            <a class="gn-icon gn-icon-search"><span>Search</span></a>
          </li>
          <li>
            <a class="gn-icon gn-icon-download">Downloads</a>
            <ul class="gn-submenu">
              <li><a class="gn-icon gn-icon-illustrator">Vector Illustrations</a></li>
              <li><a class="gn-icon gn-icon-photoshop">Photoshop files</a></li>
            </ul>
          </li>
          <li><a class="gn-icon gn-icon-cog">Settings</a></li>
          <li><a class="gn-icon gn-icon-help">Help</a></li>
          <li>
            <a class="gn-icon gn-icon-archive">Archives</a>
            <ul class="gn-submenu">
              <li><a class="gn-icon gn-icon-article">Articles</a></li>
              <li><a class="gn-icon gn-icon-pictures">Images</a></li>
              <li><a class="gn-icon gn-icon-videos">Videos</a></li>
            </ul>
          </li>
          
        </ul>
      </div>
    </nav>
  </aside>*/
  ?>