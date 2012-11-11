<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
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
    </head>
    <body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
        <?php echo $view['actions']->render('WishlistCoreBundle:Default:navBar'); ?>
        <div id="content" class="clearfix">
        <?php $view['slots']->output('_content'); ?>
        </div>
    </body>
</html>