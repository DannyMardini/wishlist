<?php
//Stylesheet
use_stylesheet('/css/userPage.css');
use_stylesheet('/css/wishlist.css');

//Javascript
use_javascript('/js/wishlist.js');
use_javascript('/js/userPage.js');
?>
<div id="div_left_panel">
    <div id="div_user_container">
        <div id="div_profile_pic">
        </div>

        <div id="div_user_info">
            <p>Name: <?php echo $wishlist_user->getFirstname()." ".$wishlist_user->getLastname(); ?></p>
            <p>Gender: <?php echo $wishlist_user->getGenderString(); ?></p>
            <p>Age: <?php echo $wishlist_user->getAge(); ?></p>
        </div>
    </div>
</div>

<div id="div_right_panel">
    <h1>Wishlist</h1>
    <?php include_component('wishlist', 'showWishlist', array('wishlistuser_id' => $wishlist_user->getWishlistuserId())); ?>
</div>

<!--<a href="<?php echo url_for('user/edit?wishlistuser_id='.$wishlist_user->getWishlistuserId()) ?>">Edit</a>-->
<!--<a href="<?php echo url_for('user/index') ?>">List</a>-->
