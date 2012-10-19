<?php

$mykey = "AIzaSyBHtgh3ihz8AHCBw0LkEi_Snl96elJCSpA";
$query = "Metal+Gear+Solid";
$hndlr = "googleQryHndlr";

//echo "<script src='https://www.googleapis.com/customsearch/v1?key=".$mykey."&cx=015228749791243702187:ctequifxi_s&q=".$query."&callback=".$hndlr."&searchType=image'></script>\n";
    
echo "<ul id='wishlistItems' class='contentItem'>\n";

foreach ($wishlistItems as $wishlistItem)
{
    echo "<li class='gbWishlistItem'><span class='picContainer'></span><label>".$wishlistItem->getName()."</label><span class='deleteButton'>X</span></li>\n";
}

echo "</ul>";
?>