<html>
    <head>
        <?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/help.css'), array('?yui_css')) as $url): ?>
        <link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>
        <?php foreach ($view['assetic']->javascripts(array('js/QABundle.js'), array('?yui_js')) as $url): ?>
        <script src="<?php echo $view->escape($url)."?rand=".rand() ?>"></script><?php endforeach; ?>
    </head>
    <body>
        <?php $view->extend('::navBar.html.php') ?>
        <header>How can we help you?</header>
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
