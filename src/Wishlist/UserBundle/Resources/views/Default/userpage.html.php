<?php
$view->extend('::navBar.html.php');

$userId = $wishlist_user->getWishlistUserId();
$selfWishlist = ($userId == $loggedInUserId)? true:false;
?>

<?php foreach ($view['assetic']->javascripts(array('js/wishlist.js', 'js/userpage.js'), array('?yui_js')) as $url): ?>
<script src="<?php echo $view->escape($url)."?rand=".rand() ?>"></script><?php endforeach; ?>
<?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/userPage.css', 'compass/stylesheets/wishlist.css'), array('?yui_css')) as $url): ?>
<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>

<input id="userId" type="hidden" value="<?php echo $userId ?>"/>

<div id="div_left_panel">
    <h2 class="pageHeader userName"><?php echo $wishlist_user->getName() ?></h2><br />
    <div id="div_user_container">
        <div id="div_profile_pic">
            <img src="<?php echo $wishlist_user->getProfileUrl($picService) ?>"/>
        </div>
    </div>
    <div id="div_user_info">
        <p><label class="user-info-label">Birthday: </label><label class="user-info"><?php echo $wishlist_user->getBirthdate()->format('M d') ?></label></p>
        <p><label class="user-info-label">Gender: </label><label class="user-info"><?php echo $wishlist_user->getGenderString() ?></label></p>
        <p><label class="user-info-label">Email: </label><label class="user-info"><?php echo $wishlist_user->getEmail() ?></label></p>
    </div>
    <button id="unfriendButton" type="button" class="btn btn-default">Unfriend</button>    
</div>

<div id="div_right_panel">
<?php    
    echo $view['actions']->render('WishlistListBundle:Wishlist:showWishlist', array('user' => $wishlist_user));
?>
</div>

