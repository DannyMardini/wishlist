<input type="hidden" id="homepageLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_homepage')?>" />
<input type="hidden" id="frontpageLinkPath" value="<?php echo $view['router']->generate('WishlistFrontpageBundle_homepage')?>" />
<input type="hidden" id="accountSettingsLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_accountsettings')?>" />
<input type="hidden" id="friendListLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_friendlist')?>" />
<input type="hidden" id="helpLinkPath" value="<?php echo $view['router']->generate('WishlistQABundle_help') ?>" />
<input type="hidden" id="eventManagerLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_lifeEventsManager') ?>" />

<div id="header">
    <div id="socialMediaLinks">
        <span class="socialMediaLink"><a href="https://www.facebook.com/pages/Wishenda/490657654383030" target="_blank"><img src="/images/facebook_32.png" alt border="0" ></a></span>
        <span class="socialMediaLink"><a href="http://www.pinterest.com/wishenda/" target="_blank"><img src="/images/pinterest_32.png" alt  border="0" ></a></span>
    </div>    
    <div id="logoContainer">        
<!--        <img id="logo" src="/images/gift.jpg"/>-->
        <div id="logoName">Wishenda</div>
    </div>
    <span id="linksContainer">
        <ul id="navigation">
            <?php if($user!=null) { ?>
            <li style="padding-right:5px;">
                <div class='UserMenu'>
                    <div class="usernameLink">
                        <span class="tinyProfile" style="background-image:url(<?php echo $user!=null ? ($user->getProfileThumb()) : ""; ?>)"></span>
                        <span class="ui-MenuLink profileName" id='homepageLink' class=""><?php echo $user->getName() ?></span>
                    </div>
                </div>
            </li>
            <li id="accountOptionsDropdownButton" class="navLink menuIcon"><div style="height:60%;padding:7px;"><span class="ui-icon ui-icon-gear"></span></div></li>
            <?php } else { ?><li>
                <a href="#">Sign-In</a>
            </li><?php } ?>
            <?php
            if(count($user->getNotifications()) > 0)
            {             
                echo "<li id='notificationsDropDown' style='vertical-align:bottom;' class='navLink menuIcon'>";
                echo "<div id='notificationDiv'><div id='viewNotificationsButton' style='height:60%;padding:7px;'><span class='ui-icon ui-icon-notice'></span></div>\n";
                echo "<div id='notificationWindow'>\n";
                echo "<ul>\n";
                foreach($user->getNotifications() as $notification)
                {
                    $notificationId = $notification->getId();
                    echo "<li id='notification_".$notificationId."' style='height:30px;' class='notifications'>
                        <span style='margin:0 10px 0 10px;'>".$notification->getText()."</span>
                        <a class='acceptFriend' href='#'>Accept</a> or
                        <a class='ignoreFriend' href='#'>Ignore</a>
                        </li>\n";
                }
                echo "</ul>\n";
                echo "</div></div>\n</li>";
            }
            ?>                    
        </ul>
    </span>
</div>

<div id="accountOptionsDropdown">
    <ul>
        <li><a id="accountSettingsLink" class="ui-MenuLink" href="#">Settings</a></li>
        <li><a id="helpLink" href="#" class="ui-MenuLink">Help</a></li>
        <li><a id="logoutLink" href="#" class="ui-MenuLink">Log Out</a></li>
    </ul>
</div>
