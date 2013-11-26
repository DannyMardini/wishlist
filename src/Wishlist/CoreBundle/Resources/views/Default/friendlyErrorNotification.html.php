<!DOCTYPE html>
<html>
    <head>
        <link href="<?php echo $view['assets']->getUrl('compass/stylesheets/errorMessageStyling.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <title>Wishenda Friendly Error Message</title>
    </head>
    <body>
        <article>            
            <div id="error_image"><img src="/images/uh-oh-page.jpg"></div>
            <div id="message"><?php echo $message; ?></div>
        </article>
    </body>
</html>
