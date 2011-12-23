<?php
use_stylesheet('homePage.css');
use_javascript('homePage.js');
use_stylesheet('/css/wishlist.css');
use_javascript('/js/wishlist.js');
?>

  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>    
  
<input id="username" type="hidden" value="<?php echo $username ?>"/>  
<input id="id" type="hidden" value="<?php echo $id ?>"/>  
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
                  <div id="userName" ><a id="userNameLink" href="#">andrea</a></div>                  
              </li>  
              <li><a href="#">Settings</a></li>
              <li><a href="#">Friends</a></li>
              <li><a href="#">Messages</a></li>
              <li><a href="#">Logout</a></li>
            </ul>
            <p style="height:157px;" id="menuCheat"></p>
        </div>   
    </div>
</div>
<div id="headerDivider"></div>

<div id="content">
    <div id="wishlistComponent">
        <div><h1>My Wishlist</h1></div>
        <?php include_component('wishlist', 'showWishlist', array('wishlistuser_id' => $id)); ?>
    </div>
    <div id="newsComponent">
        <div id="newsInnerComponent">
            <div id="2" class="friendUpdate">
                <div class="image"></div>
                <div class="name">Andrea Coba -- 12/11/2011 @ 7:00pm</div>
                <div class="info">Added the <a href="http://www.google.com">ipad2</a> to her wishlist</div>
            </div>
            <div id="1" class="friendUpdate">
                <div class="image"></div>
                <div class="name">Daniel Mardini -- Birthday coming up on 06/11/2012</div>
                <div class="info">Check <a href="http://www.google.com">Danny's wishlist</a> for gift ideas</div>
            </div>
            <div id="2" class="friendUpdate">
                <div class="image"></div>
                <div class="name">Andrea Coba -- 12/11/2011 @ 7:00pm</div>
                <div class="info">Added the <a href="http://www.google.com">ipad2</a> to her wishlist</div>
            </div>
            <div id="1" class="friendUpdate">
                <div class="image"></div>
                <div class="name">Daniel Mardini -- Birthday coming up on 06/11/2012</div>
                <div class="info">Check <a href="http://www.google.com">Danny's wishlist</a> for gift ideas</div>
            </div>
            <div id="2" class="friendUpdate">
                <div class="image"></div>
                <div class="name">Andrea Coba -- 12/11/2011 @ 7:00pm</div>
                <div class="info">Added the <a href="http://www.google.com">ipad2</a> to her wishlist</div>
            </div>
            <div id="1" class="friendUpdate">
                <div class="image"></div>
                <div class="name">Daniel Mardini -- Birthday coming up on 06/11/2012</div>
                <div class="info">Check <a href="http://www.google.com">Danny's wishlist</a> for gift ideas</div>
            </div>
            <div id="2" class="friendUpdate">
                <div class="image"></div>
                <div class="name">Andrea Coba -- 12/11/2011 @ 7:00pm</div>
                <div class="info">Added the <a href="http://www.google.com">ipad2</a> to her wishlist</div>
            </div>
            <div id="1" class="friendUpdate">
                <div class="image"></div>
                <div class="name">Daniel Mardini -- Birthday coming up on 06/11/2012</div>
                <div class="info">Check <a href="http://www.google.com">Danny's wishlist</a> for gift ideas</div>
            </div>
            <div id="2" class="friendUpdate">
                <div class="image"></div>
                <div class="name">Andrea Coba -- 12/11/2011 @ 7:00pm</div>
                <div class="info">Added the <a href="http://www.google.com">ipad2</a> to her wishlist</div>
            </div>
            <div id="1" class="friendUpdate">
                <div class="image"></div>
                <div class="name">Daniel Mardini -- Birthday coming up on 06/11/2012</div>
                <div class="info">Check <a href="http://www.google.com">Danny's wishlist</a> for gift ideas</div>
            </div>
        </div>
    </div>
</div>