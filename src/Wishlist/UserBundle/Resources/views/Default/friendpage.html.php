<?php $view->extend('::navBar.html.php') ?>
<script type="text/javascript" src="/js/friendpage.js"></script>
<link href="<?php echo $view['assets']->getUrl('compass/stylesheets/screen.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
<div class="pageTitle">
    <label class="pageHeader">Friends</label>
    <button class="addButton" title="invite friends" id="addItemButton"><span id="inviteFriendButton" class="wishenda-button">Invite Friends</span></button>
    <span class="itemCountSpan"><?php echo count($friends) ?> Friend(s)</span>
</div>
<hr size="1" width="90%" color="grey">
<div id="friendsContainer">
    <input id="friendSearch" type="text" placeholder="Find People..."/>
<?php
    if(count($friends) > 0)
    {
        echo "<div class='friendlist'>";
        echo "<div id='friendSeparator' class='listSeparator'>My Friends</div>";
        echo "<div id='div_friendlist_div'>";
        echo "<ul>";
        foreach($friends as $friend)
        {
            echo "<li><div class='userButton'>"
                ."<img class='friendIcon' src='".$friend->getProfileUrl()."'/>"
                ."<a class='friendLink' href='".$view['router']->generate('WishlistUserBundle_userpage', array('user_id' => $friend->getWishlistuserId()))."'></a>"
                    .$friend->getName()."</div></li>\n";
        }
        echo "</ul>";
        echo "</div>";
        echo "</div>";
    }
?>
</div>

<?php 
    echo $view->render('WishlistDialogBundle:Default:friendInviteDialog.html.php');
?>

