<?php
foreach ($updates as $update) {
    $message = $update->getMessage();
    $user = $update->getWishlistUser();
    $name = "<a href='".$view['router']->generate('WishlistUserBundle_userpage', array('user_id' => $user->getWishlistuserId())).
          "' >".$user->getName()."</a>";
    $timestamp = " -- ".$update->getFormattedTimestamp();


    echo    "<div class='Update'>",
            "   <div class='image'><img src='".$user->getProfileThumb($picService)."' alt='Smiley face' /></div>",
            "   <div class='name'>".$name."</div>",
            "   <div class='message'>".$message."</div>",
            "   <div class='timestamp'>".$timestamp."</div>",
            "</div>";
}

if(count($updates)<=0)
{
    echo "<div class='Update'>
        <h4>No recent activity<br /><br /><small>Remind your friends to add items to their wishlists!</small></h4>  
        </div>";
}
?>
