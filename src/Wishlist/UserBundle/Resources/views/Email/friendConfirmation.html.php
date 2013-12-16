<html>
    <body style='font-family: helvetica,sans-serif; color: #666666'>
        <p><span style='font-weight: bold; color: #333333'>Hello <?php echo $name ?>,</span><br /><br />
        You and <?php echo $friendname ?> are now friends on Wishenda. 
        <a href='<?php echo $view['router']->generate('WishlistFrontpageBundle_homepage', array(), true) ?>' style='text-decoration: none; font-weight: bolder'>Log in</a> to check out their Wish list!</p>        
    </body>
</html>
