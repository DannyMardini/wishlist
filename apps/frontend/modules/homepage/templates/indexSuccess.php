<?php
use_stylesheet('homePage.css');
use_stylesheet('/css/wishlist.css');
use_javascript('/js/wishlist.js');
?>

  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>    
  
<input id="username" type="hidden" value="<?php echo $user->getFirstname() ?>"/>
<input id="id" type="hidden" value="<?php echo $user->getWishlistuserId() ?>"/>
<?php include_component('navBar', 'showNavBar', array( 'username' => $user->getFirstName(), 'user_id' => $user->getWishlistuserId())); ?>

<div id="content" class="clearfix">
    <div id="wishlistComponent">
        <div><h1>My Wishlist</h1></div>
        <?php include_component('wishlist', 'showWishlist', array('wishlistuser_id' => $user->getWishlistuserId())); ?>
    </div>

   <div id="rightPanel">
    <div id="friendlist">
      <ul id="selectable" class="ui-selectable">
        <?php foreach ($friends as $i => $friend): ?>
        <li id="li_user_<?php echo $friend->getWishlistuserId();?>" class="ui-selectee ui-widget-content">
            <?php echo $friend->getFirstName()." ".$friend->getLastName(); ?>
        </li>
        <?php endforeach;?>
      </ul>
    </div>
  </div>
  
    <div id="newsComponent">
        <div id="newsInnerComponent">
            
            <?php   
            foreach ($friendUpdates as $update) { 
                
                    if($update->getType()==1)
                    {
                        $description = $update->getSubject()." -- Birthday is coming up on ".$update->getDatetime();
                    }
                    else if($update->getType()==4)
                    {
                        $description = $update->getSubject()." -- Anniversary is coming up on ".$update->getDatetime();
                    }
                    else
                    {
                        $description = $update->getSubject()." -- ".$update->getDatetime();
                    }                
                
                ?>
            
            <div class="Update">
                <div class="image"></div>
                <div class="name"><?php echo $description ?></div>
                <div class="info"><?php echo $update->getMessage() ?></div>
            </div>
            
            <?php } ?>
            
<!--            <div id="1" class="friendUpdate">
                <div class="image"></div>
                <div class="name">Daniel Mardini -- Birthday coming up on 06/11/2012</div>
                <div class="info">Check <a href="http://www.google.com">Danny's wishlist</a> for gift ideas</div>
            </div>
            <div id="2" class="friendUpdate">
                <div class="image"></div>
                <div class="name">Andrea Coba -- 12/11/2011 @ 7:00pm</div>
                <div class="info">Added the <a href="http://www.google.com">ipad2</a> to her wishlist</div>
            </div>
            -->
        </div>
    </div>
</div>