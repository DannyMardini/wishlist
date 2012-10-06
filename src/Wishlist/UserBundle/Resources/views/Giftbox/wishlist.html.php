<?php
echo "<ul id='wishlistItems' class='contentItem'>\n";

foreach ($wishlistItems as $wishlistItem)
{
    echo "<li>".$wishlistItem->getName()."</li>\n";
}

echo "</ul>";
?>