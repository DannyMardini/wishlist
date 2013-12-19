<?php $view->extend('::navBar.html.php') ?>
<?php foreach ($view['assetic']->javascripts(array('js/jquery.form.js', 'js/accountsettings.js'), array('?yui_js')) as $url): ?>
<script src="<?php echo $view->escape($url)."?rand=".rand() ?>"></script><?php endforeach; ?>
<?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/screen.css', 'compass/stylesheets/print.css'), array('?yui_css')) as $url): ?>
<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>
<div id='accountSettings'>
    <?php
        // This is including the settingForms.html.php template into this page
        echo  $view->render('WishlistUserBundle:Default:settingForms.html.php', array('gender' => $gender, 'name' => $name,
        'email' => $email, 'birthdate' => $birthdate, 'profileImage' => $profileImage)) ?>
</div>