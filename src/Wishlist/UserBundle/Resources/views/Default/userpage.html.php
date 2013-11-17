<?php
$view->extend('::navBar.html.php');

$userId = $wishlist_user->getWishlistUserId();
$selfWishlist = ($userId == $loggedInUserId)? true:false;
?>
<link href='/css/userPage.css' rel='stylesheet' />
<link href='/css/wishlist.css' rel='stylesheet' />
<script type="text/javascript" src="/js/wishlist.js"></script>
<script type="text/javascript" src="/js/userpage.js"></script>
<input id="userId" type="hidden" value="<?php echo $userId ?>"/>

<div id="div_left_panel">
    <h1><?php echo $wishlist_user->getName() ?></h1>
    <div id="div_user_container">
        <div id="div_profile_pic">
            <img src="<?php echo $wishlist_user->getProfileUrl() ?>"/>
        </div>
    </div>
    <div id="div_user_info">
        <p><label>Birthday: <?php echo $wishlist_user->getBirthdate()->format('M d') ?></label></p>
        <p><label>Gender: <?php echo $wishlist_user->getGenderString() ?></label></p>
        <p><label>Email: <?php echo $wishlist_user->getEmail() ?></label></p>
    </div>
    <span id='unfriendButton'>Unfriend</span>
</div>

<div id="div_right_panel">
<?php    
    echo $view['actions']->render('WishlistListBundle:Wishlist:showWishlist', array('user' => $wishlist_user));
?>
</div>

