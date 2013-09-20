<!-- TODO: This page must not be viewable to those that aren't currently logged in. -->
<?php $view->extend('::navBar.html.php') ?>

<script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>" type="text/javascript"></script>
<script src="<?php echo $view['router']->generate('fos_js_routing_js', array("callback" => "fos.Router.setData")) ?>"></script>

<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/friendpage.js"></script>

<div id="friendsContainer">
    <input id="friendSearch" type="text" placeholder="Find People..."/>
    <!--<div id='friendlist'></div>-->
<?php
    if(count($friends) > 0)
    {
        echo "<div class='friendlist'>";
        echo "<div id='friendSeparator' class='listSeparator'>My Friends</div>";
        echo "<div id='div_friendlist_div'>";
        echo "<ul>";
        foreach($friends as $friend)
        {
            echo "<li><div class='userButton'>"
                ."<img class='friendIcon' src='".$friend->getProfileUrl()."'/>"
                ."<a class='friendLink' href='".$view['router']->generate('WishlistUserBundle_userpage', array('user_id' => $friend->getWishlistuserId()))."'></a>"
                    .$friend->getName()."</div></li>\n";
        }
        echo "</ul>";
        echo "</div>";
        echo "</div>";
    }
?>
</div>
