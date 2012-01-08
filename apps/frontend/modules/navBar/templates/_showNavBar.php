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