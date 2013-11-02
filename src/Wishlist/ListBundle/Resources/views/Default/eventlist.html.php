<?php
foreach ($events as $event) {
    echo "<div id='event_".$event->getId()."' class='confirmEvent'>".$event->getName()."</div>\n";
}
?>
