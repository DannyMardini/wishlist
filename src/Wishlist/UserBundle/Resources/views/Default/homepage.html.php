
<?php $view->extend('::navBar.html.php') ?>


<?php foreach ($view['assetic']->javascripts(array('js/homepage.js', 'js/wishlist.js'), array('?yui_js')) as $url): ?>
<script src="<?php echo $view->escape($url) ?>"></script><?php endforeach; ?>
<?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/homePage.css'), array('?yui_css')) as $url): ?>
<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url) ?>" /><?php endforeach; ?>

<input id="username" type="hidden" value="<?php echo $user->getName() ?>"/>
<input id="id" type="hidden" value="<?php echo $user->getWishlistuserId() ?>"/>

<div id="wishlistContent">
    <?php echo $view['actions']->render('WishlistListBundle:Wishlist:showWishlist', array('user' => $user)); ?>
</div>

