<?php $view->extend('::navbar.html.php') ?>
<script type="text/javascript" src="/js/friendpage.js"></script>
<link href='/css/friendPage.css' rel='stylesheet' type="text/css" />

<div id="friendsContainer">
    <input id="friendSearch" type="text" placeholder="Find People..."/>
    <div id="friendlist">
        <div class="listSeparator">
            My Friends
        </div>
            <div id='div_friendlist_div'>
            <?php
                echo "<ul>";
                foreach($friends as $friend)
                {
                    echo "<li><img class='friendIcon' src='".$friend->getProfileUrl()."'/><a href='".$view['router']->generate('WishlistUserBundle_userpage', array('user_id' => $friend->getWishlistuserId()))."'>"
                            .$friend->getFirstname()." ".$friend->getLastname()."</a></li>\n";
                }
                echo "</ul>";
                ?>
            </div>
        <div class="listSeparator">
            People
        </div>
        Person one.         +
    </div>
</div>
