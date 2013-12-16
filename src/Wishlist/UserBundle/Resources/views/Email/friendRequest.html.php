<html>
    <body style='font-family: helvetica,sans-serif; color: #666666'>
        <p><span style='font-weight: bold; color: #333333'>Hello <?php echo $name ?>,</span><br /><br />
        <?php echo $friendname ?> has requested to be your friend on Wishenda. 
        <a href='<?php echo $view['router']->generate('WishlistUserBundle_acceptFriendRequestEmail', array('notificationId' => $notificationId), true) ?>' 
           style='text-decoration: none; font-weight: bolder'>Click here</a> to accept the request!</p>
    </body>
</html>
