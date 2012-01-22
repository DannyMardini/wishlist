<?php
//Stylesheet
use_stylesheet('/css/userPage.css');
use_stylesheet('/css/wishlist.css');

//Javascript
use_javascript('/js/wishlist.js');

$default_pic = "images/default_avatar.gif";
$user_pic = "images/user/".$wishlist_user->getWishlistuserId()."/profile.jpg";

if( file_exists($user_pic) )
{
    $profile_pic = $user_pic;
}else
{
    $profile_pic = $default_pic;
}
?>

<!--<div id="div_user_info">
    <h1><?php echo $wishlist_user->getFirstname()." ".$wishlist_user->getLastname(); ?></h1>
</div>-->

<div id="div_left_panel">
    <div id="div_user_container">
        <div id="div_profile_pic">
            <img src="/<?php echo $profile_pic ?>"/>
        </div>
    </div>
</div>

<div id="div_right_panel">
    <h1><?php echo $wishlist_user->getFirstname()." ".$wishlist_user->getLastname(); ?></h1>
<!--    <h2>Wishlist</h2>-->
    <?php include_component('wishlist', 'showWishlist', array('wishlistuser_id' => $wishlist_user->getWishlistuserId())); ?>
</div>

<!--<a href="<?php echo url_for('user/edit?wishlistuser_id='.$wishlist_user->getWishlistuserId()) ?>">Edit</a>-->
<!--<a href="<?php echo url_for('user/index') ?>">List</a>-->
