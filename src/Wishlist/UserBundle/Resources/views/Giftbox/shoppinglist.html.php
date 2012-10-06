<?php
echo "<ul id='shoppinglistItems' class='contentItem'>\n";

foreach ($purchases as $purchase)
{
    echo "<li>".$purchase->getItem()->getName()."</li>\n";
}

echo "</ul>";
?>