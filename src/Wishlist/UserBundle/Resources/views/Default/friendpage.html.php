<?php $view->extend('::navbar.html.php') ?>

<div id='friendlist'>
<?php
echo $view->render('WishlistListBundle:Default:friendlist.html.php', array('friends' => $friends));
?>
</div>