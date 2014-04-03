<?php
use Wishlist\CoreBundle\Entity\Item;

if(count($items) > 0)
{
    echo "<table>\n";
    foreach($items as $item) {
        echo "<tr id='".$item->getvendorId()."'><td class='searchResultItemLink'><a href='".$item->getLink()."' target='_blank'><img src=".$item->getSmallImage()." alt='Item Image'></a></td><td class='searchResultItemName'>"
                .$item->getName()."</td><td>$<span class='searchResultItemPrice'>".($item->getPrice(Item::CURRENCY_UNIT_DOLLAR))."</span></td></tr>\n";
    }
    echo "</table>\n";
}
else
{
    echo "<p>No search results found</p>";
}

?>