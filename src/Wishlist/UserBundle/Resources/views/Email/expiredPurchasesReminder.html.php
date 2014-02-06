<html>
<body style='font-family: helvetica,sans-serif; color: #666666'>
    <p><span style='font-weight: bold; color: #333333'>Hello <?php echo $name ?>,</span><br /><br />
    Did you remember to give your friends their gifts? If so, go to <a href='<?php echo $view['router']->generate('WishlistUserBundle_shoppinglist', array(), true) ?>' 
       style='text-decoration: none; font-weight: bolder'>Wishenda</a>, to update your shopping list.
    <br />Otherwise, be sure to get their gift(s) soon!
</body>
</html>