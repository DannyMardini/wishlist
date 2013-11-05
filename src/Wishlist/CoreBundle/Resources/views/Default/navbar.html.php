<input type="hidden" id="homepageLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_homepage')?>" />
<input type="hidden" id="frontpageLinkPath" value="<?php echo $view['router']->generate('WishlistFrontpageBundle_homepage')?>" />
<input type="hidden" id="accountSettingsLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_accountsettings')?>" />
<input type="hidden" id="friendListLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_friendlist')?>" />
<input type="hidden" id="helpLinkPath" value="<?php echo $view['router']->generate('WishlistQABundle_help') ?>" />
<input type="hidden" id="eventManagerLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_lifeEventsManager') ?>" />

<div class="Header">
    <div class="headerBackground"></div>
    <div class="headerContainer centeredWithinWrapper">
        <div class="leftHeaderContent">
            <span class="socialMediaLink"><a href="https://www.facebook.com/pages/Wishenda/490657654383030" target="_blank"><img src="/images/facebook_32.png" alt border="0" ></a></span>
            <span class="socialMediaLink"><a href="http://www.pinterest.com/wishenda/" target="_blank"><img src="/images/pinterest_32.png" alt  border="0" ></a></span>
        </div>
        <div style="float:left">
            <div id="logoContainer">        
                <div id="logoname" class="logo">Wishenda<span id='betaTag'>beta</span></div>
            </div>
        </div>
        <div class="rightHeaderContent">
            <span id="linksContainer">
                <ul id="navigation" class="font-style">
                    <li class="navButtons">
                            <span class="profilePicture" style="background-image:url(<?php echo $user!=null ? ($user->getProfileThumb()) : ""; ?>)"></span>
                            <span id='homepageLink' class="navcenter ui-MenuLink"><?php echo $user->getName() ?></span>
                    </li><li id="updatesWindowButton" class="navButtons smallNavButtons" title="Updates">
                        <span class="ui-icon ui-icon-star navcenter"></span>
                    </li><li id="accountOptionsDropdownButton" class="navButtons smallNavButtons"><span class="ui-icon ui-icon-gear navcenter"></span>
                    <?php
                    if(count($user->getNotifications()) > 0)
                    {
                        //Note, there cannot be any white-space between li's if you want them to show up right next to each other.
                        echo "</li><li id='notificationsDropDown' class='navButtons smallNavButtons'>";
                        echo "<div id='notificationDiv' class='navcenter'><div id='viewNotificationsButton'><span class='ui-icon ui-icon-notice'></span></div>\n";
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
                    else
                    {
                        //Note, there cannot be any white-space between li's if you want them to show up right next to each other.
                        echo "</li>";
                    }
                    ?>                    
                </ul>
            </span>
        </div>
    </div>    
    <div id="accountOptionsDropdown" class="positionModuleFixed">
        <ul>
            <li id="accountSettingsLink" class="ui-MenuLink"><a href="#">Settings</a></li>
            <li id="helpLink" class="ui-MenuLink"><a href="#">Help</a></li>
            <li id="logoutLink" class="ui-MenuLink"><a href="#">Log Out</a></li>
        </ul>
    </div>    
</div>
