
<?php $view->extend('::navBar.html.php') ?>

<link href='/css/homePage.css' rel='stylesheet' type="text/css" />
<script type="text/javascript" src="/js/homepage.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/wishlist.js"></script>
<link href="/css/wishlist.css" rel="stylesheet" type="text/css" />
<link href="/css/formStyling.css" rel="stylesheet" type="text/css" />
  
<input id="username" type="hidden" value="<?php echo $user->getFirstname() ?>"/>
<input id="id" type="hidden" value="<?php echo $user->getWishlistuserId() ?>"/>

<div id="updatesComponent">
    <h2>Updates</h2>
    
    <div id="updatesInnerComponent">

        <?php
        foreach ($friendUpdates as $update) {
                  $message = $update->getMessage();
                  $user = $update->getWishlistUser();
                  $name = "<a href='".$view['router']->generate('WishlistUserBundle_userpage', array('user_id' => $user->getWishlistuserId())).
                          "' >".$user->getFirstname()." ".$user->getLastname()."</a>";
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

<div class="spacer"></div>

<!--<div class="giftBox" >-->
<div id="giftBox" class="mockup">
    <ul id="giftNav">
        <li>Wishlist</li>
        <li>Shoppinglist</li>
        <li>Events</li>
        <li>Friends</li>
    </ul>
    <div id="giftContent" class="mockup">

        <?php echo $view['actions']->render('WishlistUserBundle:Giftbox:wishlist'); ?>
<!--        <div id="wishlistComponent">
            <div id="wishlist">
                <?php // echo $view['actions']->render('WishlistListBundle:Wishlist:showWishlist', array('user' => $user)); ?>
            </div>-->
<!--        </div>-->
    </div>
    <!--
    <div id="eventsComponent">
        <br />
        <div><h1>Upcoming Events</h1></div>
        <div id="eventsInnerComponent">  
        <?php  
        foreach ($friendEvents as $event) {
                $eventImage = $event->getEventImage();
                $eventName = $event->getName();
                $friend = $event->getWishlistUser();
                $eventDate = $event->getFormattedTimestamp();
                $name = "<a href='User/".$friend->getWishlistUserId()."/' >".$friend->getFirstname()." ".$friend->getLastname()."</a>";
                $timestamp = " -- ".$eventDate;
        ?>  
            <div class="Event"> 
                <div class="image" title="<?php echo $eventName ?>"><img src="<?php echo $eventImage ?>" height="30" width="30" /></div>
                <div class="name" title ="<?php echo $eventName ?>"><?php echo $name ?></div>
                <div class="message" title="<?php echo $eventName ?>"><?php echo $timestamp ?></div>
            </div>
        <?php } ?>
        </div>
    </div>
    -->
</div>

<div id="itemDialog" title="Wish" >        
    <label class="label">Name: </label>
    <div id="name"></div>
    <label class="label">Price: </label>
    <div id="price"></div>
    <label class="label">Quantity: </label>
    <div id="quantity">2</div>
    <label class="label">Website: </label>
    <div id="link"></div>
    <label class="label">Comment: </label>
    <div id="comment"></div>
</div>
