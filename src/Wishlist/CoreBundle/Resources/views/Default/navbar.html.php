<input type="hidden" id="homepageLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_homepage')?>" />
<input type="hidden" id="frontpageLinkPath" value="<?php echo $view['router']->generate('WishlistFrontpageBundle_homepage')?>" />
<input type="hidden" id="accountSettingsLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_accountsettings')?>" />
<input type="hidden" id="friendListLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_friendlist', array('user_id' => $user->getWishlistuserId())) ?>" />
<input type="hidden" id="helpLinkPath" value="<?php echo $view['router']->generate('WishlistQABundle_help') ?>" />
<input type="hidden" id="eventManagerLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_lifeEventsManager') ?>" />

<div id="header">
    <div id="logoContainer">
        <img id="logo" src="/images/gift.jpg"/>
        <div id="name">Wishlist</div>
    </div>
    <span id="linksContainer">
        <ul id="navigation">
       <!--            
                WOW, html and css suck... are you kidding me?? inline-block is the more correct approach here...
                HOWEVER if there is a line break between successive li's then there will be a small gap between them 
                in the actual presentation... html and css are fucking broken...
            -->
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
                    echo "<div id='notificationDiv'>!\n";
                    echo "<div id='notificationWindow'>\n";
                    echo "<ul>\n";
                    foreach($user->getNotifications() as $notification)
                    {
                        echo "<li id='notification_".$notification->getId()."'>".$notification->getText()."<a href='#'>Accept</a><a href='#'>Ignore</a></li>\n";
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
