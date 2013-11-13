
<?php $view->extend('::navBar.html.php') ?>

<link href='/css/homePage.css' rel='stylesheet' type="text/css" />
<script type="text/javascript" src="/js/homepage.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/wishlist.js"></script>
  
<input id="username" type="hidden" value="<?php echo $user->getName() ?>"/>
<input id="id" type="hidden" value="<?php echo $user->getWishlistuserId() ?>"/>

<div id="wishlistContent" class="mockup">
    
    <?php
    // This is calling the Default controller calling the action = wishlist
    echo $view['actions']->render('WishlistUserBundle:Default:wishlist'); ?>
</div>

