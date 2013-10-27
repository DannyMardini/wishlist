<?php $view->extend('::navBar.html.php') ?>
<!--
<link href="/css/formStyling.css" rel="stylesheet" type="text/css" />
<link href="/css/accountsettings.css" rel="stylesheet" type="text/css" />
<link href="/css/navBar.css" rel="stylesheet" type="text/css" />
-->
<link href="<?php echo $view['assets']->getUrl('compass/stylesheets/screen.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
<link href="<?php echo $view['assets']->getUrl('compass/stylesheets/print.css') ?>" media="print" rel="stylesheet" type="text/css" />
<div id='accountSettings'>
    <?php
        // This is including the settingForms.html.php template into this page
        echo  $view->render('WishlistUserBundle:Default:settingForms.html.php', array('gender' => $gender, 'name' => $name,
        'email' => $email, 'profileImage' => $profileImage, 'originalPassword' => $originalPassword)) ?>
</div>
