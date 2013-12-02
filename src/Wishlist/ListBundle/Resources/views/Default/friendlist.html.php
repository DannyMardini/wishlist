<div id='div_friendlist_div'>
<?php
if(count($friends) > 0){
echo "<ul>";
foreach($friends as $friend)
{
    echo "<li><img class='friendIcon' src='".$friend->getProfileUrl()."'/><a href='".$view['router']->generate('WishlistUserBundle_userpage', array('user_id' => $friend->getWishlistuserId()))."'>"
            .$friend->getName()."</a></li>\n";
}
echo "</ul>";
}
else {
    echo "test test";
}
?>
</div>
