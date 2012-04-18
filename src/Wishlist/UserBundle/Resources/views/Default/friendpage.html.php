<?php $view->extend('::navbar.html.php') ?>
<link href='/css/friendPage.css' rel='stylesheet' type="text/css" />

<label>Friends of <?php echo $username?></label>

<div id='friendlist'>
<?php
echo $view->render('WishlistListBundle:Default:friendlist.html.php', array('friends' => $friends, 'pic_service' => $pic_service));
?>
</div>