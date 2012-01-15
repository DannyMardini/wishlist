<?php
use_stylesheet('homePage.css');
use_stylesheet('/css/wishlist.css');
use_javascript('/js/wishlist.js');
use_javascript('/js/homepage.js');
?>
  
<input id="username" type="hidden" value="<?php echo $user->getFirstname() ?>"/>
<input id="id" type="hidden" value="<?php echo $user->getWishlistuserId() ?>"/>

<div id="content" class="clearfix">
    <div id="wishlistComponent">
        <div><h1>My Wishlist</h1></div>
        <div id="wishlist">
          <?php include_component('wishlist', 'showWishlist', array('wishlistuser_id' => $user->getWishlistuserId())); ?>
        </div>
    </div>
  
    <div id="updatesComponent">
        <div id="updatesInnerComponent">
            
            <?php   
            foreach ($friendUpdates as $update) { 
                
                    $message = $update->getMessage(ESC_RAW);                    
                    $name = "<a href='user/".$update->getUserId()."/' >".$update[concat]."</a>";                                   
                    $timestamp = " -- ".$update->getFormattedTimestamp();
                
                ?>
            
            <div class="Update">
                <div class="image"></div>
                <div class="name"><?php echo $name ?></div>
                <div class="message"><?php echo $message ?></div>
                <div class="timestamp"><?php echo $timestamp ?></div>
            </div>
           
            <?php } ?>
        </div>
    </div>
    
    
    <div id="itemDialog" title="temp">        
        <div id="name"></div>
        <div id="price"></div>
        <div id="link"></div>
    </div>
</div>