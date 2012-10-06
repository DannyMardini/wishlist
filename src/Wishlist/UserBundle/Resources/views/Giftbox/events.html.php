<?php
echo "<ul id='events' class='contentItem'>\n";

foreach ($events as $event)
{
    echo "<li>".$event->getName()."</li>\n";
}

echo "</ul>";
?>