<?php
use_stylesheet("friendlist.css");
?>

<script>
    $(function() {
        $( "li" ).click(function(){
            window.location = "http://www.google.com";
           // alert("I told you bapper");
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
        <li class="ui-selectee ui-widget-content">
            <?php echo $friend ?>
        </li>
        <?php endforeach;?>
    </ul>
</div>