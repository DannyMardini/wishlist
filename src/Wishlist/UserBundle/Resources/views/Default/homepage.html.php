
<?php $view->extend('::navBar.html.php') ?>

<link href='/css/homePage.css' rel='stylesheet' type="text/css" />
<script type="text/javascript" src="/js/homepage.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/wishlist.js"></script>
<link href="/css/formStyling.css" rel="stylesheet" type="text/css" />
  
<input id="username" type="hidden" value="<?php echo $user->getName() ?>"/>
<input id="id" type="hidden" value="<?php echo $user->getWishlistuserId() ?>"/>

<div id="updatesComponent">
    <div class="updatesHeader">Recent Friend Activity</div>    
    
    <div id="updatesInnerComponent">

        <?php
        foreach ($friendUpdates as $update) {
                  $message = $update->getMessage();
                  $user = $update->getWishlistUser();
                  $name = "<a href='".$view['router']->generate('WishlistUserBundle_userpage', array('user_id' => $user->getWishlistuserId())).
                          "' >".$user->getName()."</a>";
                  $timestamp = " -- ".$update->getFormattedTimestamp();

            ?>

        <div class="Update">
            <div class="image"><img src="<?php echo $user->getProfileThumb(); ?>" alt="Smiley face" /></div>
            <div class="name"><?php echo $name ?></div>
            <div class="message"><?php echo $message ?></div>
            <div class="timestamp"><?php echo $timestamp ?></div>
        </div>

        <?php } ?>
    </div>
</div>

<div id="wishlistContent" class="mockup">
    
    <?php
    // This is calling the Default controller calling the action = wishlist
    echo $view['actions']->render('WishlistUserBundle:Default:wishlist'); ?>
</div>
<?php
echo  $view->render('WishlistDialogBundle:Default:showFriendsWishItem.html.php') ?>
<!--<div id='itemDialog' title='Wish' >  
    <input type='hidden' id='itemId' /> 
    Name: <input disabled type='text' id='name' placeholder='Enter Name' /> 
    Price: <input disabled type='text' id='price' placeholder='Enter Price' />
    Link: <div id='link2'></div> <input type='hidden' id='link' />
</div>-->