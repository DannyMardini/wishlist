<html>
    <body style='font-family: helvetica,sans-serif; color: #666666'>
        <p>You have been invited to join Wishenda!</p>

        <p><a href='<?php echo $view['router']->generate('WishlistUserBundle_newAccountUser', array('acceptId' => $acceptId), true) ?>' style='text-decoration: none; font-weight: bolder'>Join Wishenda</a> and get your shopping done effortlessly! With Wishenda you know what all of your friends want and they know what you want, shopping for each other has never been easier!</p>
        <br /><br />
        <a href='<?php echo $view['router']->generate('WishlistUserBundle_newAccountUser', array('acceptId' => $acceptId), true) ?>' style='text-decoration: none; font-weight: bolder'>Join Now!</a>
    </body>
</html>
