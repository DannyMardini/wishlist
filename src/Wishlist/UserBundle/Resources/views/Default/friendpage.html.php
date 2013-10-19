<!-- TODO: This page must not be viewable to those that aren't currently logged in. -->
<?php $view->extend('::navBar.html.php') ?>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/friendpage.js"></script>
<div id="friendsHeader">
    <label class="pageHeader">Friends ( <?php echo count($friends) ?> )</label>
    <span id="inviteFriendButton" class="wishenda-button">+</span>
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

<div id="friendInviteDialog" title="Invite a friend!">
    <form id="friendInviteForm">
        <p>Want to invite a friend to help you shop for them?</p>
        <p><label>Email:</label><input name="email" id="newFriendEmail" type="email" placeholder="johndoe@email.com"></p>
        <input id="friendInviteFormSubmit" type="submit" name="submitFriend" style="display: none" required>
    </form>
</div>

