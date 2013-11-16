<!DOCTYPE html>
<html>
    <head>
        <link href="<?php echo $view['assets']->getUrl('compass/stylesheets/resetpassword.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="/images/favicon.ico">
        <title>Reset Password</title>
    </head>
    <body>
        <header>Reset Password</header>
        <form id="reset-password">        
        <article id='getPasswordResetInstructions'>
            <label class="instructions">Enter your email address and we will send you instructions.</label>            
            <label class="form-input-label">Email</label>
            <input id='email' type="text"></input>            
            <button type='submit'>Submit</button>
        </article>
        </form>
    </body>
</html>
