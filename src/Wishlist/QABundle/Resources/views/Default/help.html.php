<html>
    <head>
        <link href="/css/help.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <header>How can we help you?</header>
        <div class="content">
            <div class="contentMenu">
                <?php //echo $view['actions']->render('WishlistQABundle:Default:QAMenu'); ?>
                <?php echo $view->render('WishlistQABundle:Default:QAMenu.html.php'); ?>
            </div>
            <div class="contentInfo"></div>
        </div>
        <footer>end</footer>
    </body>    
</html>