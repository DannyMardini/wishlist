<html>
    <head>
        <link href="/css/help.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/QABundle.js"></script>
    </head>
    <body>
        <?php $view->extend('::navBar.html.php') ?>
<!--        <span id="goBack" class="goBackDiv"><img src="/images/goback.jpeg" /></span>-->
        <header>
            How can we help you?
        </header>
        <div class="content">
            <div class='contentMenuContainer'>
                <div class="contentMenu">
                    <?php echo $view->render('WishlistQABundle:Default:QAMenu.html.php', array('selectedOptionIndex' => 0)); ?>
                </div>
            </div>
            <div class="contentInfo">
            </div>
        </div>
        <footer></footer>
    </body>
</html>
