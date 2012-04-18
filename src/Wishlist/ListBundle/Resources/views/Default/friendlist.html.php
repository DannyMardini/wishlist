<div id='div_friendlist_div'>
<?php
echo "<ul>";
foreach($friends as $friend)
{
    echo "<li><img class='friendIcon' src='".$pic_service->getProfileUrl($friend->getWishlistuserId())."'/><a href='".$view['router']->generate('WishlistUserBundle_userpage', array('user_id' => $friend->getWishlistuserId()))."'>"
            .$friend->getFirstname()." ".$friend->getLastname()."</a></li>\n";
}
echo "</ul>";
?>
</div>
