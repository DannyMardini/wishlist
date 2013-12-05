
<?php $view->extend('::navBar.html.php') ?>

<link href="<?php echo $view['assets']->getUrl('compass/stylesheets/homePage.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/homepage.js"></script>
<script type="text/javascript" src="/js/wishlist.js"></script>
  
<input id="username" type="hidden" value="<?php echo $user->getName() ?>"/>
<input id="id" type="hidden" value="<?php echo $user->getWishlistuserId() ?>"/>

<div id="wishlistContent">
    <?php echo $view['actions']->render('WishlistListBundle:Wishlist:showWishlist', array('user' => $user)); ?>
</div>

