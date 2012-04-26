<?php 
$view->extend('::navBar.html.php');

?>
The Shopping List!

<?php echo $view['actions']->render('WishlistListBundle:Default:shoppinglist', array('userId' => $userId)); ?>
