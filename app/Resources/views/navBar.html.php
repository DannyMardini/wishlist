<?php
$wishlistUrl = $view['router']->generate('WishlistUserBundle_homepage');
$shoppinglistUrl = $view['router']->generate('WishlistUserBundle_shoppinglist');
$eventsUrl = $view['router']->generate('WishlistUserBundle_lifeEventsManager');
$friendsUrl = $view['router']->generate('WishlistUserBundle_friendlist', array('user_id' => $view['session']->get('user_id')));
?>
<html>
    <head>
        <link rel="shortcut icon" href="/images/favicon.ico" />

        <script type="text/javascript" src="/js/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-1.8.23.custom.min.js"></script>
        <link href="/css/black-tie/jquery-ui-1.8.23.custom.css" rel="stylesheet" />

        <script type="text/javascript" src="/js/navBar.js"></script>
        <link href="/css/main.css" rel="stylesheet" type="text/css" />
        <link href="/css/navBar.css" rel="stylesheet" type="text/css" />
        <link href="/compass/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="/compass/stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
        <!--[if IE]>
            <link href="/compass/stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
        <![endif]-->
        <script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>" type="text/javascript"></script>
        <script src="<?php echo $view['router']->generate('fos_js_routing_js', array("callback" => "fos.Router.setData")) ?>"></script>
    </head>
    <body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
        <?php echo $view['actions']->render('WishlistCoreBundle:Default:navBar'); ?>
        <ul id="navigationlist">
            <li><a href="<?php echo $wishlistUrl ?>">Wishlist</a></li>
            <li><a href="<?php echo $shoppinglistUrl ?>">Shoppinglist</a></li>
            <li><a href="<?php echo $eventsUrl ?>">Events</a></li>
            <li><a href="<?php echo $friendsUrl ?>">Friends</a></li>
        </ul>
        <div id="content" class="clearfix">
        <?php $view['slots']->output('_content'); ?>
        </div>
    </body>
</html>
