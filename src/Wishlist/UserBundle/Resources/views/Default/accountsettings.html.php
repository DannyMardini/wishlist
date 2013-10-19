<?php $view->extend('::navBar.html.php') ?>

<html>
    <head>
        <link href="/css/formStyling.css" rel="stylesheet" type="text/css" />
        <link href="/css/accountsettings.css" rel="stylesheet" type="text/css" />
        <link href="/css/navBar.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/QABundle.js"></script>
        <script type="text/javascript" src="/js/jquery.form.js"></script>
        <script type="text/javascript" src="/js/accountsettings.js"></script>
        <script type="text/javascript" src="/js/common.js"></script>
    </head>
    <body>
        <?php echo  $view->render('WishlistUserBundle:Default:settingForms.html.php', array('gender' => $gender, 'name' => $name,
                                                                                            'email' => $email, 'profileImage' => $profileImage)) ?>
    </body>
</html>
