<div id='div_friendlist_div'>
<?php
echo "<ul>";
foreach($friends as $friend)
{
    echo "<li>".$friend->getFirstname()." ".$friend->getLastname()."</li>\n";
}
echo "</ul>";
?>
</div>
