
<?php $view->extend('::navBar.html.php') ?>

<link href='/css/homePage.css' rel='stylesheet' type="text/css" />
<script type="text/javascript" src="/js/homepage.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/wishlist.js"></script>
<link href="/css/wishlist.css" rel="stylesheet" type="text/css" />
<link href="/css/formStyling.css" rel="stylesheet" type="text/css" />
  
<input id="username" type="hidden" value="<?php echo $user->getName() ?>"/>
<input id="id" type="hidden" value="<?php echo $user->getWishlistuserId() ?>"/>

<div id="updatesComponent">
    <h2>Updates</h2>
    
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

<div id="wishlistBox" class="mockup">
    <div id="wishlistContent" class="mockup">
        <?php echo $view['actions']->render('WishlistUserBundle:Default:wishlist'); ?>
    </div>
</div>

<div id='itemDialog' title='Wish' >  
    <input type='hidden' id='itemId' /> 
    Name: <div id='name'></div>
    Price:<div id='price'></div>
    Link: <div id='link'></div>
    <span id='wishDetails' style='display:none'>        
    <input type='text' id='notes' placeholder='Notes (Optional)'/>
    <input type='text' id='quantity' placeholder='Quantity (Default = 1)'/>
    <span style='display:inline-block;'>Keep this wish private:</span>
    <input style='width:25%;display:inline-block;' type='checkbox' id='isPrivate' />
    </span>
</div>
