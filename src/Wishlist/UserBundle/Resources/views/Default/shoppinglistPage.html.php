<?php 
$view->extend('::navBar.html.php');

echo $view['actions']->render('WishlistListBundle:Shoppinglist:shoppinglist', array('userId' => $userId)); 
?>
