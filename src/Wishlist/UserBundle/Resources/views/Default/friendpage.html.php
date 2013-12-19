<?php $view->extend('::navBar.html.php') ?>

<?php foreach ($view['assetic']->javascripts(array('js/friendpage.js'), array('?yui_js')) as $url): ?>
<script src="<?php echo $view->escape($url)."?rand=".rand() ?>"></script><?php endforeach; ?>
<?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/screen.css'), array('?yui_css')) as $url): ?>
<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>

<div class="pageTitle">
    <label class="pageHeader">Friends</label>
    <button class="addButton" title="invite friends" id="inviteFriendButton"><span class="wishenda-button">Invite Friends</span></button>
    <span class="itemCountSpan"><?php echo count($friends) ?> Friend(s)</span>
</div>
<hr size="1" width="90%" color="grey">
<div id="friendsContainer">
    <input id="friendSearch" type="text" placeholder="Find People on Wishenda..."/>
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
                ."<img class='friendIcon' src='".$friend->getProfileUrl($picService)."'/>"
                ."<a class='friendLink' href='".$view['router']->generate('WishlistUserBundle_userpage', array('user_id' => $friend->getWishlistuserId()))."'></a>"
                    .$friend->getName()."</div></li>\n";
        }
        echo "</ul>";
        echo "</div>";
        echo "</div>";
    }
    else {
        echo "<div class='message'>You haven't added any friends yet, you can: <br /><br />            
            1. Search for people to add to your friends list by typing a name in the search box, or <br /><br />
            2. Invite friends to join Wishenda by clicking 'Invite Friends' above.</div>";
    }
?>
</div>

<?php 
    echo $view->render('WishlistDialogBundle:Default:friendInviteDialog.html.php');
?>

