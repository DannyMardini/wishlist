<?php use_stylesheet('homePage.css') ?>
<?php use_javascript('homePage.js') ?>

  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>    
  
<form>
<input id="hi_username" type="hidden" value="<?php echo $username ?>"/>  
<input id="hi_id" type="hidden" value="<?php echo $id ?>"/>  
<div id="header">
    <div id="logoContainer">
        <div id="name">Wishlist</div>
    </div>
    <div id="linksContainer">
        <div id="profileLinks">            
             <ul id="linkList">              
              <li id="mainProfileLink">
                  <div id="userPicture"></div>
                  <div id="userName" ><a id="userNameLink" href="#">Andrea</a></div>                  
              </li>  
              <li><a href="#">Settings</a></li>
              <li><a href="#">Friends</a></li>              
              <li><a href="#">Logout</a></li>
            </ul>
            <p style="height:157px;" id="menuCheat"></p>
        </div>   
    </div>
</div>
<div id="wishlistComponent">wishlist</div>
<div id="newsComponent">news updates</div>
<div id="footer">footer</div>
</form>