<!DOCTYPE html>
<html>
    <head>
        <?php foreach ($view['assetic']->javascripts(array('js/jquery-1.8.2.js', 'js/resetpassword_request.js', 'js/common.js'), array('yui_js')) as $url): ?>
        <script src="<?php echo $view->escape($url) ?>"></script><?php endforeach; ?>
        <?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/resetpassword.css'), array('yui_css')) as $url): ?>
        <link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url) ?>" /><?php endforeach; ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="/images/favicon.ico">
        <title>Reset Password</title>
    </head>
    <body>
        <header>Reset Password</header>
        <form id="reset-password" class="reset-password" method="POST" action="<?php echo $view['router']->generate('WishlistQABundle__resetpasswordrequest') ?>">        
        <article id='getPasswordResetInstructions'>
            <label class="instructions">Enter your email address and we will send you instructions.</label>            
            <label class="form-input-label">Email</label>
            <input id='email' type="text"></input>            
            <button type='submit'>Submit</button>
        </article>
        </form>
        <article id="message"></article>
        <button id="close-window">Close</button>
    </body>
</html>
