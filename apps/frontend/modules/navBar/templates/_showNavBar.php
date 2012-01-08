<?php
use_stylesheet('navBar.css');
use_javascript('navBar.js');
?>

<div id="header">
    <div id="logoContainer">
        <div id="logo"></div>
        <div id="name">Wishlist</div>
    </div>
    <div id="linksContainer">
        <div id="profileLinks">
            <ul id="linkList">
              <li id="mainProfileLink">
                  <div id="userPicture"></div>
                  <div id="userName" ><a id="userNameLink" href="#"><?php echo $username ?></a></div>
              </li>
              <li><a href="#">Settings</a></li>
              <li><a id="friend_button" href="#">Friends</a></li>
              <li><a href="#">Messages</a></li>
              <li><a href="#">Logout</a></li>
            </ul>
            <p style="height:157px;" id="menuCheat"></p>
        </div>
    </div>
</div>

<div id="rightPanel">
    <div id="friendlist">
<!--    <ul id="selectable" class="ui-selectable">-->
    <ul>
      <?php foreach ($friends as $i => $friend): ?>
      <li id="li_user_<?php echo $friend->getWishlistuserId();?>">
          <a href='<?php echo url_for('user/show?wishlistuser_id='.$friend->getWishlistuserId());?>'><?php echo $friend->getFirstName()." ".$friend->getLastName(); ?></a>
      </li>
      <?php endforeach;?>
    </ul>
  </div>
</div>