<div id='div_friendlist_div'>
<?php
echo "<ul>";
foreach($friends as $friend)
{
    echo "<li><img class='friendIcon' src='/images/user/".$friend->getWishlistuserId()."/profile.jpg'/><a href='".$view['router']->generate('WishlistUserBundle_userpage', array('user_id' => $friend->getWishlistuserId()))."'>"
            .$friend->getFirstname()." ".$friend->getLastname()."</a></li>\n";
}
echo "</ul>";
?>
</div>
