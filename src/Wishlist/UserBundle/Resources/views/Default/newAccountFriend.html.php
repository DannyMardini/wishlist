<?php 
$view->extend('WishlistUserBundle:Default:newAccountBase.html.php');

$view['slots']->set('title', 'New Wishlist User Account');

$view['slots']->set('heading', 'New User Account');

$greeting = 'Hey there, '.$friend.' invited you to Wishenda! Finish filling out your new account!';
$view['slots']->set('greeting', $greeting);
?>
