<?php
use_stylesheet('homePage.css');
use_stylesheet('/css/wishlist.css');
use_javascript('/js/wishlist.js');
?>

  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>    
  
<input id="username" type="hidden" value="<?php echo $user->getFirstname() ?>"/>
<input id="id" type="hidden" value="<?php echo $user->getWishlistuserId() ?>"/>

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
  
    <div id="updatesComponent">
        <div id="updatesInnerComponent">
            
            <?php   
            foreach ($friendUpdates as $update) { 
                
                    $message = $update->getMessage(ESC_RAW);                    
                    $description = $update[concat];                                   
                    $timestamp = " -- ".$update->getFormattedTimestamp();
                
                ?>
            
            <div class="Update">
                <div class="image"></div>
                <div class="name"><?php echo $description ?></div>
                <div class="info"><?php echo $message ?></div>
                <div class="timestamp"><?php echo $timestamp ?></div>
            </div>
            
            <?php } ?>
        </div>
    </div>
</div>