<div id="header">
    <div id="logoContainer">
        <img id="logo" src="/images/gift.jpg"/>
        <div id="name">Wishlist</div>
    </div>
    <div id="linksContainer">
        <ul id="navigation">
            <li>
                <img class="tinyProfile" src="<?php echo "/images/user/".$user->getWishlistuserId()."/profile.jpg" ?>"/>
            </li>
            
            <li class="navLink">
                <a href="<?php echo $view['router']->generate('WishlistUserBundle_homepage')?>"><?php echo $user->getFirstName() ?></a>
            </li>
            
            <li class="navLink">
                <a href="<?php echo $view['router']->generate('WishlistUserBundle_friendlist', array('user_id' => $user->getWishlistuserId())) ?>">Friends</a>
            </li>
            
<!--            <li class="navLink">
                <a href="#">Settings</a>
            </li>-->
        </ul>
    </div>
</div>

<div id="rightPanel">
    <div id="friendlist">
<!--    <ul id="selectable" class="ui-selectable">-->
    <ul>
    <?php // foreach ($friends as $i => $friend): ?>
    <li id="li_user_<?php // echo $friend->getWishlistuserId();?>">
        <a href='<?php // echo url_for('user/show?wishlistuser_id='.$friend->getWishlistuserId());?>'><?php // echo $friend->getFirstName()." ".$friend->getLastName(); ?></a>
    </li>
    <?php // endforeach;?>
    </ul>
    </div>
</div>