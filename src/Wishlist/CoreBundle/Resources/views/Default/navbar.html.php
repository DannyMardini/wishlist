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
            <div class="btn-group">  
              <div class="btn-group">    
                <span class="profilePicture" style="background-image:url(<?php echo $user!=null ? ($profileThumb) : ""; ?>)"></span>    
                <button id="accountOptionsDropdownButton" type="button" class="btn btn-default dropdown-toggle navButton" data-toggle="dropdown"><?php echo $user->getName() ?></button>
                <ul class="dropdown-menu">
                    <li id="accountSettingsLink" class="ui-MenuLink"><a href="#">Settings</a></li>
                    <li id="helpLink" class="ui-MenuLink"><a href="#">Help</a></li>
                    <li id="logoutLink" class="ui-MenuLink"><a href="#">Log Out</a></li>
                </ul>
              </div>
                <button type="button" for="updatesComponent" id="updatesWindowButton" class="btn btn-default headerButton navButton"><span class="ui-icon ui-icon-star navcenter"></span></button>                
                <?php
                if(count($user->getNotifications()) > 0)
                {  
                    echo "<button id='viewNotificationsButton' for='notificationWindow' type='button' class='btn btn-default headerButton navButton'><span class='ui-icon ui-icon-notice blue'></span></button></div>";
                    echo "<div id='notificationDiv' class='navcenter'>\n";
                    echo "<div id='notificationWindow' class='navBarComponent panel panel-default'>\n";
                    echo "<ul class='list-group'>\n";
                    foreach($user->getNotifications() as $notification)
                    {
                        $notificationId = $notification->getId();
                        echo "<li class='list-group-item notifications' id='notification_".$notificationId."'>
                                <h5 style='margin:10px 10px 10px 10px;'>".$notification->getText()."
                                <small><a class='acceptFriend' href='#'>Accept</a> or
                                <a class='ignoreFriend' href='#'>Ignore</a></small></h5>                                                   
                            </li>\n";
                    }
                    echo "</ul>\n";
                    echo "</div></div>";
                }  
                else {
                    echo "</div>";
                }
                ?>
            </div> 
        </div>
</div>
