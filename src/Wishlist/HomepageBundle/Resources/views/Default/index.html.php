<?php $view->extend('::navBar.html.php') ?>

<link href='/css/homePage.css' rel='stylesheet' />
<link href='/css/wishlist.css' rel='stylesheet' />
<script type="text/javascript" src="/js/wishlist.js"></script>
<script type="text/javascript" src="/js/homepage.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
  
<input id="username" type="hidden" value="<?php echo $user->getFirstname() ?>"/>
<input id="id" type="hidden" value="<?php echo $user->getWishlistuserId() ?>"/>

<div class="sideBar" >
    <div id="wishlistComponent">
        <div><h1>My Wishlist</h1></div>
        <div id="wishlist">
            Wishlist Here.
            <?php // include_component('wishlist', 'showWishlist', array('wishlistuser_id' => $user->getWishlistuserId())); ?>
        </div>
    </div>

    <div id="upcomingEvents">
        <div><h1>Upcoming Events</h1></div>
        <div id="events">
            <div><h2>Birthdays</h2></div>
            <div id="birthdays"></div>
            <div><h2>Anniversaries</h2></div>
            <div id="anniversaries"></div>
        </div>
    </div>

</div>

<div id="updatesComponent">
    <div id="updatesInnerComponent">

        <?php
//        foreach ($friendUpdates as $update) {

//                $message = $update->getMessage(ESC_RAW);
//                $name = "<a href='user/".$update->getUserId()."/' >".$update[concat]."</a>";
//                $timestamp = " -- ".$update->getFormattedTimestamp();

            ?>

        <div class="Update">
            <div class="image"><img src="/images/default_avatar.gif" alt="Smiley face" height="42" width="42" /></div>
            <div class="name"><?php // echo $name ?></div>
            <div class="message"><?php // echo $message ?></div>
            <div class="timestamp"><?php // echo $timestamp ?></div>
        </div>

        <?php // } ?>
    </div>
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
    <div id="comment"</div>
</div>
