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
        <img id="logo" src="/images/gift.jpg"/>
        <div id="name">Wishenda</div>
    </div>
    <span id="linksContainer">
        <ul id="navigation">
            <?php if($user!=null) { ?>
            <li style="padding-right:5px;">
                <div class="buttonClass">
                    <img class="tinyProfile" src="<?php echo $user!=null ? ($user->getProfileThumb()) : ""; ?>"/>    
                    <span id="homepageLink" class="ui-MenuLink"><?php echo $user->getName() ?></span>
                </div>
            </li><li>
                <?php
                if(count($user->getNotifications()) > 0)
                {
                    echo "<div id='notificationDiv'><span id='openNotificationsButton'>!</span>\n";
                    echo "<div id='notificationWindow'>\n";
                    echo "<ul>\n";
                    foreach($user->getNotifications() as $notification)
                    {
                        $notificationId = $notification->getId();
                        echo "<li id='notification_".$notificationId."' class='notifications'>".$notification->getText()."    <a class='acceptFriend' href='#'>Accept</a>    <a class='ignoreFriend' href='#'>Ignore</a></li>\n";
                    }
                    echo "</ul>\n";
                    echo "</div></div>\n";
                }
                ?>
            </li>
            <li id="dropDownButton" class="navLink"><span class="ui-icon ui-icon-carat-1-s"></span></li>
            <?php } else { ?><li>
                <a href="#">Sign-In</a>
            </li><?php } ?>
        </ul>
    </span>
</div>

<div id="dropDownMenu">
    <ul>
        <li><a id="accountSettingsLink" class="ui-MenuLink" href="#">Settings</a></li>
        <li><a id="helpLink" href="#" class="ui-MenuLink">Help</a></li>
        <li><a id="logoutLink" href="#" class="ui-MenuLink">Log Out</a></li>
    </ul>
</div>
