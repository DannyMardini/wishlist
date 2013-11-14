<html>
    <head>
        <!--
        <link href="<?php echo $view['assets']->getUrl('css/accountsettings.css') ?>" rel="stylesheet" type="text/css" />
        -->
        <link href="<?php echo $view['assets']->getUrl('compass/stylesheets/screen.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="<?php echo $view['assets']->getUrl('compass/stylesheets/print.css') ?>" media="print" rel="stylesheet" type="text/css" />
        <link href="<?php echo $view['assets']->getUrl('css/black-tie/jquery-ui-1.8.23.custom.css') ?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src=<?php echo $view['assets']->getUrl('/js/jquery-1.8.2.js') ?>></script>
        <script type="text/javascript" src=<?php echo $view['assets']->getUrl('/js/jquery-ui-1.8.23.custom.min.js') ?>></script>
        <link href="/css/black-tie/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
        <title><?php $view['slots']->output('title', 'New Account Base') ?></title>
    </head>
    <body id='accountSettings'>
        <h1><?php $view['slots']->output('heading');?></h1>
        <p id='greeting'><?php $view['slots']->output('greeting'); ?></p>
<?php
        $formParams = array();
        if(isset($gender))
            $formParams['gender'] = $gender;

        if(isset($name))
            $formParams['name'] = $name;

        if(isset($email))
            $formParams['email'] = $email;

        if(isset($profileImage))
            $formParams['profileImage'] = $profileImage;
        
        if(isset($originalPassword))
            $formParams['originalPassword'] = $originalPassword;

        echo  $view->render('WishlistUserBundle:Default:settingForms.html.php', $formParams);
?>
    </body>
</html>
