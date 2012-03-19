

<?php $view->extend('::main.html.php') ?>
<script type="text/javascript" src="/js/wishlist.js"></script>
<link href="<?php echo $view['assets']->getUrl('css/wishlist.css') ?>" rel="stylesheet" type="text/css" />
<div id="wishlist">
<?php 
echo $view['actions']->render('WishlistWishlistBundle:Default:index', array('wishlistuser_id' => $user_id)) 
?>
</div>