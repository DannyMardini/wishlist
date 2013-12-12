<?php
use Wishlist\CoreBundle\Entity\Item;

echo "<table>\n";
foreach($items as $item) {
    echo "<tr id='".$item->getAsin()."'><td class='searchResultItemLink'><a href='".$item->getLink()."' target='_blank'><span class='ui-icon ui-icon-link'></span></a></td><td class='searchResultItemName'>"
            .$item->getName()."</td><td>$<span class='searchResultItemPrice'>".($item->getPrice(Item::CURRENCY_UNIT_DOLLAR))."</span></td></tr>\n";
}
echo "</table>\n";

?>