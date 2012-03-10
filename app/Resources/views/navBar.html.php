<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
        <link href='http://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' />
        <link href='http://fonts.googleapis.com/css?family=Gruppo' rel='stylesheet' />
        <link rel="shortcut icon" href="/images/favicon.ico">
        <script type="text/javascript" src="/js/jquery-1.7.1.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-1.8.16.custom.min"></script>
        <link href="/css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
        <link href="/css/main.css" rel="stylesheet" type="text/css" />
        
        <script type="text/javascript" src="/js/navBar.js"></script>
        <link href="/css/navBar.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        
        <div id="header">
            <div id="logoContainer">
                <div id="logo"></div>
                <div id="name">Wishlist</div>
            </div>
            <div id="linksContainer">
                <div id="profileLinks">
                    <ul id="linkList">
                    <li id="mainProfileLink">
                        <div id="userPicture"></div>
                        <div id="userName" ><a id="userNameLink" href="#"><?php echo $user->getFirstName() ?></a></div>
                    </li>
                    <li><a href="#">Settings</a></li>
                    <li><a id="friend_button" href="#">Friends</a></li>
                    <li><a href="#">Messages</a></li>
                    <li><a href='<?php // echo url_for('navBar/logout'); ?>'>Logout</a></li>
                    </ul>
                    <p style="height:157px;" id="menuCheat"></p>
                </div>
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
        
        <?php $view['slots']->output('_content'); ?>
    </body>
</html>