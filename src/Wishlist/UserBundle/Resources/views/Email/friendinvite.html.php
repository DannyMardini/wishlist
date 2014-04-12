<html>
    <body style='font-family: helvetica,sans-serif; color: #666666'>
        <p><span style='font-weight: bold; color: #333333'><?php echo $name ?></span> wants to give you a gift but doesn't know what you want. Help them shop for you by joining Wishenda!</p>

        <p><a href='<?php echo $view['router']->generate('WishlistUserBundle_newAccountFriend', array('acceptId' => $acceptId), true) ?>' style='text-decoration: none; font-weight: bolder'>Join Wishenda</a> and get your shopping done effortlessly! With Wishenda you know what all of your friends want and they know what you want, shopping for each other has never been easier!</p>
    </body>
</html>
