<?php
$view->extend('::navBar.html.php');

$userId = $wishlist_user->getWishlistUserId();
$selfWishlist = ($userId == $loggedInUserId)? true:false;
?>

<?php foreach ($view['assetic']->javascripts(array('js/wishlist.js', 'js/userpage.js'), array('?yui_js')) as $url): ?>
<script src="<?php echo $view->escape($url) ?>"></script><?php endforeach; ?>
<?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/userPage.css', 'compass/stylesheets/wishlist.css'), array('?yui_css')) as $url): ?>
<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url) ?>" /><?php endforeach; ?>

<input id="userId" type="hidden" value="<?php echo $userId ?>"/>

<div id="div_left_panel">
    <h1><?php echo $wishlist_user->getName() ?></h1>
    <div id="div_user_container">
        <div id="div_profile_pic">
            <img src="<?php echo $wishlist_user->getProfileUrl($picService) ?>"/>
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

