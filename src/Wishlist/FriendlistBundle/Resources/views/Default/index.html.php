<link href='/css/friendlist.css' rel='stylesheet' />

<script>
    $(function() {
        $( "li" ).click(function(){
            var loc = "http://www.wishlist.localhost.com/user/"
            window.location = loc + this.id.replace("li_user_","")+"/";
        });

        $("li").hover(function(){$(this).addClass("ui-selected")},
            function(){$(this).removeClass("ui-selected")}
        );
    });
</script>

<div id="friendlist">
    <p>Friends of <?php echo $user ?></p>
    <ul id="selectable" class="ui-selectable">
        <?php foreach ($friends as $i => $friend): ?>
        <li id="li_user_<?php echo $friend->getWishlistuserId();?>" class="ui-selectee ui-widget-content">
            <?php echo $friend->getFirstName()." ".$friend->getLastName(); ?>
        </li>
        <?php endforeach;?>
    </ul>
</div>
