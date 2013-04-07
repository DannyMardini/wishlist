<!-- TODO: This page must not be viewable to those that aren't currently logged in. -->
<?php $view->extend('::navbar.html.php') ?>

<script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>" type="text/javascript"></script>
<script src="<?php echo $view['router']->generate('fos_js_routing_js', array("callback" => "fos.Router.setData")) ?>"></script>

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
