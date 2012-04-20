<html>
    <head>
        <link href="/css/help.css" rel="stylesheet" type="text/css" />
            <link href="/css/navBar.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php $view->extend('::navBar.html.php') ?>
        <header>How can we help you?</header>
        <div class="content">
            <div class="contentMenu">                
                <?php echo $view->render('WishlistQABundle:Default:QAMenu.html.php', array('selectedOptionIndex' => 3)); ?>
            </div>
            <div class="contentInfo">
                <div class="contentInfoTopic">Adding Wishes</div>
                <div class="contentInfoDetails">
                    To DO
                </div>
                <div class="contentInfoTopic">Removing Wishes</div>
                <div class="contentInfoDetails">
                    To DO
                </div>                
                <div class="contentInfoTopic">Granting a Wish</div>
                <div class="contentInfoDetails">
                    To DO
                </div>                   
            </div>
        </div>
        <footer>end</footer>
    </body>    
</html>
