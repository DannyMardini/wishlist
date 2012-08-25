<input type="hidden" id="homepageLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_homepage')?>" />
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
                    <img class="tinyProfile" src="<?php echo $user!=null ? ($user->getProfileUrl()) : ""; ?>"/>    
                    <span id="homepageLink" class="ui-MenuLink"><?php echo $user->getFirstName() ?></span>
                </div>
            </li><li>
                <div class="buttonClass ui-MenuLink" id="eventManagerLink">
                    <img src="/images/calendar_icon.png" title="Life Events" />
                </div>
            </li>
            <li style="padding-right:5px;">
                <div class="buttonClass ui-MenuLink" id="friendListLink">
                    <img src='/images/friend_icon.png' title='Friends' />
                </div>
            </li><li id="dropDownButton" class="navLink"><span class="ui-icon ui-icon-carat-1-s"></span></li>
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
        <li><a href="#">Log Out</a></li>
    </ul>
</div>