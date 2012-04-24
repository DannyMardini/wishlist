<?php 
$view->extend('::navBar.html.php');

?>
The Shopping List!

<?php $view['actions']->render('WishlistListBundle:Default:shoppinglist', array('userId' => $userId)); ?>
