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
            <li>
                <img class="tinyProfile" src="<?php echo $user!=null ? ($user->getProfileUrl()) : ""; ?>"/>
            </li><li class="navLink">
                <a href="<?php echo $view['router']->generate('WishlistUserBundle_homepage')?>"><?php echo $user->getFirstName() ?></a>
            </li><li class="navLink">
                <a href="<?php echo $view['router']->generate('WishlistUserBundle_friendlist', array('user_id' => $user->getWishlistuserId())) ?>">Friends</a>
            </li><li id="dropDownButton" class="navLink"><span class="ui-icon ui-icon-carat-1-s"></span></li>
            <?php } else { ?><li>
                <a href="#">Sign-In</a>
            </li><?php } ?>
        </ul>
    </span>
</div>

<div id="dropDownMenu">
    <ul>
        <li><a href="#">Settings</a></li>
        <li><a href="#">Help</a></li>
        <li><a href="#">Log Out</a></li>
    </ul>
</div>