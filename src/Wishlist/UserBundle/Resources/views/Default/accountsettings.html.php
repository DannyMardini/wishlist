<?php $view->extend('::navBar.html.php') ?>
<link href="<?php echo $view['assets']->getUrl('compass/stylesheets/screen.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
<link href="<?php echo $view['assets']->getUrl('compass/stylesheets/print.css') ?>" media="print" rel="stylesheet" type="text/css" />
<div id='accountSettings'>
    <?php
        // This is including the settingForms.html.php template into this page
        echo  $view->render('WishlistUserBundle:Default:settingForms.html.php', array('gender' => $gender, 'name' => $name,
        'email' => $email, 'birthdate' => $birthdate, 'profileImage' => $profileImage)) ?>
</div>
<script type="text/javascript" src=<?php echo $view['assets']->getUrl('/js/jquery.form.js') ?>></script>
<script type="text/javascript" src=<?php echo $view['assets']->getUrl('/js/accountsettings.js') ?>></script>
