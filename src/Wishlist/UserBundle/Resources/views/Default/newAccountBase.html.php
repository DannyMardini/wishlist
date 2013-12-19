<html>
    <head>
        <?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/screen.css', 'compass/stylesheets/print.css'), array('?yui_css')) as $url): ?>
        <link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>        
        <link href="<?php echo $view['assets']->getUrl('css/black-tie/jquery-ui-1.8.23.custom.css') ?>" rel="stylesheet" type="text/css" />
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
        <script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>" type="text/javascript"></script>
        <script src="<?php echo $view['router']->generate('fos_js_routing_js', array("callback" => "fos.Router.setData")) ?>"></script>
        <script type="text/javascript" src=<?php echo $view['assets']->getUrl('/js/jquery-1.8.2.js') ?>></script>
        <script type="text/javascript" src=<?php echo $view['assets']->getUrl('/js/jquery-ui-1.8.23.custom.min.js') ?>></script>
        <script type="text/javascript" src=<?php echo $view['assets']->getUrl('/js/common.js') ?>></script>
        <script type="text/javascript" src=<?php echo $view['assets']->getUrl('/js/QABundle.js') ?>></script>
        <script type="text/javascript" src=<?php echo $view['assets']->getUrl('/js/jquery.form.js') ?>></script>
        <script type="text/javascript" src=<?php echo $view['assets']->getUrl('/js/accountsettings.js') ?>></script>
    </body>
</html>
