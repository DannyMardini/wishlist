<html>
<body style='font-family: helvetica,sans-serif; color: #666666'>
    <p><span style='font-weight: bold; color: #333333'>Hello <?php echo $name ?>,</span><br /><br />
    You have expired items in your shopping list! Did you remember to give your friends their gifts? <br />
    Log into <a href='<?php echo $view['router']->generate('WishlistUserBundle_shoppinglist', array(), true) ?>' 
       style='text-decoration: none; font-weight: bolder'>Wishenda</a>, to update your shopping list.
    <br />
</body>
</html>