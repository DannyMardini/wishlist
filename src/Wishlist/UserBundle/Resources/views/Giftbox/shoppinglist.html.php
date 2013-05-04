<?php
echo "<ul id='shoppinglistItems' class='contentItem'>\n";

echo $view['actions']->render('WishlistListBundle:Shoppinglist:shoppinglist', array('userId' => $userId));

echo "</ul>";
?>