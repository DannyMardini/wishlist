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
        <form id="submit-new-password" class="reset-password" method="POST" action="<?php echo $view['router']->generate('WishlistQABundle__savenewpassword') ?>">        
        <article id='getPasswordResetInstructions'>
            <label class="instructions">Enter the new password below</label>
            <div class="submit-new-password"><label class="form-input-label">New password</label></div>
            <input id='new_password1' type="text"></input><br />
            <div class="submit-new-password"><label class="form-input-label">Type it again</label></div>
            <input id='new_password2' type="text"></input>
            <button type='submit'>Submit</button>
        </article>
        </form>
    </body>
</html>
