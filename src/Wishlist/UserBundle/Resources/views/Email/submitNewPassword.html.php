<html>
    <body style='font-family: helvetica,sans-serif; color: #666666'>
        <header>Hi <?php echo $username ?>!</header>
        <p>You have asked to reset your Wishenda password! If you did not submit this request
        please ignore this email. Otherwise, you have 24 hours to follow the link and reset your password.</p>

        <p><a href='<?php 
        echo $view['router']->generate('WishlistQABundle__submitnewpassword', 
                array('token' => $token, 'email' => $email), true) 
        ?> ' style='text-decoration: none; font-weight: bolder'>Reset Password</a></p>
    </body>
</html>
