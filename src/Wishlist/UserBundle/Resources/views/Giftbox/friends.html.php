<?php
echo "<ul id='friends' class='contentItem'>\n";

foreach ($friends as $friend)
{
    echo "<li>".$friend->getFirstname()." ".$friend->getLastname()."</li>\n";
}

echo "</ul>";
?>