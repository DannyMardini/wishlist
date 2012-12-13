<?php
echo "<ul id='shoppinglistItems' class='contentItem'>\n";

echo $view['actions']->render('WishlistListBundle:Shoppinglist:shoppinglist', array('userId' => $userId));

//foreach ($purchases as $purchase)
//{
//    echo "<li>".$purchase->getItem()->getName()."</li>\n";
//}

echo "</ul>";
?>