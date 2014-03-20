<?php $view->extend('::navBar.html.php') ?>

<?php foreach ($view['assetic']->javascripts(array('js/friendpage.js'), array('?yui_js')) as $url): ?>
<script src="<?php echo $view->escape($url)."?rand=".rand() ?>"></script><?php endforeach; ?>
<?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/main.css'), array('?yui_css')) as $url): ?>
<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>

<div class="pageTitle">
    <h2 class="pageHeader">Friends</h2>
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
        echo "<br />
        <div class='jumbotron'>
          <h1><small>Shop for friends by looking at their wish lists</small></h1>
          <h3>Add friends...</h3>
          <p><span class='bullet-icon ui-icon ui-icon-carat-1-e'></span>Search for people on Wishenda by typing a name in the search box <br />
          <span class='bullet-icon ui-icon ui-icon-carat-1-e'></span>Invite friends to join Wishenda by clicking the 'Invite Friends' button
          </p>  
        </div>";
    }
?>
</div>

<?php 
    echo $view->render('WishlistDialogBundle:Default:friendInviteDialog.html.php');
?>

