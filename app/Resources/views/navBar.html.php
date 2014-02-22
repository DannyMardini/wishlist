<?php
$wishlistUrl = $view['router']->generate('WishlistUserBundle_homepage');
$shoppinglistUrl = $view['router']->generate('WishlistUserBundle_shoppinglist');
$eventsUrl = $view['router']->generate('WishlistUserBundle_lifeEventsManager');
$friendsUrl = $view['router']->generate('WishlistUserBundle_friendlist');
?>
<html>
    <head>
        <link rel="shortcut icon" href="/images/favicon.ico" />
        <?php foreach ($view['assetic']->stylesheets(array(            
            'compass/stylesheets/main.css',            
            'css/bootstrap/tablecloth.css',
            'css/bootstrap/prettify.css',
            'compass/stylesheets/navBar.css',
            'compass/stylesheets/screen.css',
            'compass/stylesheets/print.css',
            'css/bootstrap/bootstrap.css',
            'css/bootstrap/bootstrap-responsive.css',            
            'compass/stylesheets/formStyling.css'), array('?yui_css')) as $url): ?>
        <link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>
        <link href="<?php echo $view['assets']->getUrl('compass/stylesheets/fonts.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="<?php echo $view['assets']->getUrl('/css/black-tie/jquery-ui-1.8.23.custom.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <?php foreach ($view['assetic']->javascripts(array(
            'js/jquery-1.8.2.js',
            'js/bootstrap/bootstrap.js',
            'js/bootstrap/jquery.metadata.js',
            'js/bootstrap/jquery.tablecloth.js',
            'js/common.js',
            'js/navBar.js'), array('?yui_js')) as $url): ?>
            <script src="<?php echo $view->escape($url)."?rand=".rand() ?>"></script>
        <?php endforeach; ?>
        <script src="/js/jquery-ui-1.8.23.custom.min.js"></script>
        <script src="/js/bootstrap/jquery.tablesorter.min.js"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>" type="text/javascript"></script>
        <script src="<?php echo $view['router']->generate('fos_js_routing_js', array("callback" => "fos.Router.setData")) ?>"></script>
    </head>
    <body>
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
        <?php 
            $view['slots']->output('_content');

            if(preg_match('/(?i)msie [4-8]/',$_SERVER['HTTP_USER_AGENT']))
            {
                echo "<h3 style='color: FF8282;'>Please consider upgrading to a modern browser such as 
                    <a href='https://www.google.com/intl/en/chrome/browser/' target='none'>Chrome</a> or 
                    <a href='http://www.mozilla.org/en-US/firefox/new/' target='none'>Firefox</a></h3>\n";
            }
        ?>
        </div>
        <?php 
            echo $view->render('WishlistDialogBundle:Default:amazonSearchDialog.html.php');
            echo $view->render('WishlistDialogBundle:Default:showFriendsWishItem.html.php');
            echo $view->render('WishlistDialogBundle:Default:editItemDialog.html.php');
            echo $view->render('WishlistDialogBundle:Default:confirmPurchaseDialog.html.php');
        ?>
    </body>
</html>
