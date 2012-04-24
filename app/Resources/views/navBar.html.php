<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
        <link rel="shortcut icon" href="/images/favicon.ico" />
        <script type="text/javascript" src="/js/jquery-1.7.1.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-1.8.16.custom.min"></script>
        <script type="text/javascript" src="/js/navBar.js"></script>        
        <link href="/css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
        <link href="/css/main.css" rel="stylesheet" type="text/css" />                
        <link href="/css/navBar.css" rel="stylesheet" type="text/css" />        
    </head>
    <body>
        <?php echo $view['actions']->render('WishlistCoreBundle:Default:navBar'); ?>
        <div id="content" class="clearfix">
        <?php $view['slots']->output('_content'); ?>
        </div>
    </body>
</html>