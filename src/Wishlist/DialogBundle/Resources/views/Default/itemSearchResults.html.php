<?php
echo "<table>\n";
foreach($items as $item) {
    echo "<tr><td><a target='_blank' href='".$item->getLink()."'>".$item->getName()."</a></td><td>$".($item->getPrice() / 100)."</td></tr>\n";
}
echo "</table>\n";

?>