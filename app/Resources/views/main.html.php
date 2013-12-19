<html>
    <head>
        <link rel="shortcut icon" href="/images/favicon.ico">        
        <?php foreach ($view['assetic']->javascripts(array(
            'js/common.js', 
            'js/jquery-1.8.2.js', 
            'js/jquery-ui-1.8.23.custom.min.js'), array('?yui_js')) as $url): ?>
        <script src="<?php echo $view->escape($url)."?rand=".rand() ?>"></script><?php endforeach; ?>
        <link href="<?php echo $view['assets']->getUrl('/css/black-tie/jquery-ui-1.8.23.custom.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />        
    </head>
    <body>
        <?php $view['slots']->output('_content'); ?>
    </body>
</html>