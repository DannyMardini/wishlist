<?php

foreach($items as $item) {
    echo "<div><a href='".$item->getLink()."'>".$item->getName()."</a>".$item->getPrice()."</div>";
}

?>