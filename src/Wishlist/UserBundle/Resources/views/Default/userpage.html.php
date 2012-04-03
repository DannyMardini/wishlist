<?php
$view->extend('::navBar.html.php');

$default_pic = "images/default_avatar.gif";
$user_pic = "images/user/".$wishlist_user->getWishlistuserId()."/profile.jpg";

if( file_exists($user_pic) )
{
    $profile_pic = $user_pic;
}else
{
    $profile_pic = $default_pic;
}


$selfWishlist = ($wishlist_user->getWishlistUserId() == $loggedInUserId)? true:false;
?>
<script type="text/javascript" src="/js/common.js"></script>
<link href='/css/userPage.css' rel='stylesheet' />
<link href='/css/wishlist.css' rel='stylesheet' />
<script type="text/javascript" src="/js/wishlist.js"></script>

<div id="div_left_panel">
    <div id="div_user_container">
        <div id="div_profile_pic">
            <img src="/<?php echo $profile_pic ?>"/>
        </div>
    </div>
    <div id="div_user_info">
        <p><label>Born <?php echo $wishlist_user->getBirthdate()->format('M d, Y') ?></label></p>
        <p><label><?php echo $wishlist_user->getGender() ?></label></p>
        <p><label><?php echo $wishlist_user->getEmail() ?></label></p>
    </div>
</div>

<div id="div_right_panel">
    <h1><?php echo $wishlist_user->getFirstname()." ".$wishlist_user->getLastname(); ?></h1>
    <?php echo $view->render('WishlistListBundle:Default:wishlist.html.php', array('selfWishlist' => $selfWishlist,'wishlistItems' => $wishlist_user->getWishlistItems())); ?>
</div>
