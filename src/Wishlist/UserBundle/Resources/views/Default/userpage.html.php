<?php
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
<script type="text/javascript" src="/js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.8.16.custom.min"></script>
<link href="/css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
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
        <p><label><?php echo $wishlist_user->getBirthdate()->format('m/d/Y') ?></label></p>
        <p><label><?php echo $wishlist_user->getGender() ?></label></p>
        <p><label><?php echo $wishlist_user->getEmail() ?></label></p>
    </div>
</div>

<div id="div_right_panel">
    <h1><?php echo $wishlist_user->getFirstname()." ".$wishlist_user->getLastname(); ?></h1>
    <?php echo $view->render('WishlistWishlistBundle:Default:index.html.php', array('selfWishlist' => $selfWishlist,'wishlistItems' => $wishlist_user->getWishlistItems())); ?>
</div>
