<?php
$wishlistUrl = $view['router']->generate('WishlistUserBundle_homepage');
$shoppinglistUrl = $view['router']->generate('WishlistUserBundle_shoppinglist');
$eventsUrl = $view['router']->generate('WishlistUserBundle_lifeEventsManager');
$friendsUrl = $view['router']->generate('WishlistUserBundle_friendlist');
?>
<html>
    <head>
        <link rel="shortcut icon" href="/images/favicon.ico" />
        <link href="/css/black-tie/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
        <link href="/css/main.css" rel="stylesheet" type="text/css" />
        <link href="/css/bootstrap/bootstrap.css" rel="stylesheet">
        <link href="/css/bootstrap/bootstrap-responsive.css" rel="stylesheet">
        <link href="/css/bootstrap/tablecloth.css" rel="stylesheet">
        <link href="/css/bootstrap/prettify.css" rel="stylesheet">                
        <link href="<?php echo $view['assets']->getUrl('compass/stylesheets/navBar.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />        
        <link href="/compass/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="/compass/stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
        <link href="<?php echo $view['assets']->getUrl('compass/stylesheets/formStyling.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
        
        <script type="text/javascript" src="/js/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-1.8.23.custom.min.js"></script>        
        <script src="/js/bootstrap/bootstrap.js"></script>
        <script src="/js/bootstrap/jquery.metadata.js"></script>
        <script src="/js/bootstrap/jquery.tablesorter.min.js"></script>
        <script src="/js/bootstrap/jquery.tablecloth.js"></script>             
        <script type="text/javascript" src="/js/navBar.js"></script>        
        
        <script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>" type="text/javascript"></script>
        <script src="<?php echo $view['router']->generate('fos_js_routing_js', array("callback" => "fos.Router.setData")) ?>"></script>
    </head>
    <body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
        <?php echo $view['actions']->render('WishlistCoreBundle:Default:navBar'); ?>
        <ul id="navigationlist" class="font-style">
            <li><a href="<?php echo $wishlistUrl ?>">Wishlist</a></li>
            <li><a href="<?php echo $shoppinglistUrl ?>">Shoppinglist</a></li>
            <li><a href="<?php echo $eventsUrl ?>">Events</a></li>
            <li><a href="<?php echo $friendsUrl ?>">Friends</a></li>
        </ul>

        <div id="updatesComponent" class="positionmodulefixed">
            <div class="updatesHeader">Recent Friend Activity</div>    

            <div id="updatesInnerComponent">
                <?php echo $view['actions']->render('WishlistUserBundle:Default:updates'); ?>
            </div>
        </div>

        <div id="content" class="clearfix">
        <?php $view['slots']->output('_content'); ?>
        </div>
        <?php 
            echo $view->render('WishlistDialogBundle:Default:showFriendsWishItem.html.php');
            echo $view->render('WishlistDialogBundle:Default:editItemDialog.html.php');
            echo $view->render('WishlistDialogBundle:Default:confirmPurchaseDialog.html.php');
        ?>
        <script type="text/javascript" src="/js/common.js"></script>
    </body>
</html>
