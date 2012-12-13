<?php 
$view->extend('::navBar.html.php');

echo "The Shopping List!";

echo $view['actions']->render('WishlistListBundle:Shoppinglist:shoppinglist', array('userId' => $userId)); 
?>
