<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="/js/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="/js/resetpassword_request.js"></script>
        <script type="text/javascript" src="/js/common.js"></script>        
        <link href="<?php echo $view['assets']->getUrl('compass/stylesheets/resetpassword.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
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
