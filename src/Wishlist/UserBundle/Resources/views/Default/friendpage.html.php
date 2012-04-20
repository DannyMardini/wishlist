<?php $view->extend('::navbar.html.php') ?>
<script type="text/javascript" src="/js/friendpage.js"></script>
<link href='/css/friendPage.css' rel='stylesheet' type="text/css" />

<span class="uiButton">Friends of <?php echo $username?></span>

<div id='friendlist'>
<?php
echo $view->render('WishlistListBundle:Default:friendlist.html.php', array('friends' => $friends));
?>
</div>