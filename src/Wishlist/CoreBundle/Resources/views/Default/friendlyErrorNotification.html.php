<!DOCTYPE html>
<html>
    <head>
        <?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/errorMessageStyling.css'), array('?yui_css')) as $url): ?>
        <link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>
        <title>Wishenda Friendly Error Message</title>
    </head>
    <body>
        <article>            
            <div id="error_image"><img src="/images/uh-oh-page.jpg"></div>
            <div id="message"><?php echo $message; ?></div>
        </article>
    </body>
</html>
