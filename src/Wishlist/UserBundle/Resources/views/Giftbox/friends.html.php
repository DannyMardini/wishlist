<?php
echo "<ul id='friends' class='contentItem'>\n";

foreach ($friends as $friend)
{
    echo "<li>".$friend->getName()."</li>\n";
}

echo "</ul>";
?>