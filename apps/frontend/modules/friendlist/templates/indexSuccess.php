<?php
use_stylesheet("friendlist.css");
?>

<script>
    $(function() {
       $( "#selectable" ).selectable();

    });
</script>


<div id="friendlist">
    <p>Friends:</p>
    <ul id="selectable" class="ui-selectable">
        <?php foreach ($friends as $i => $friend): ?>
        <!--<li class="<?php echo fmod($i, 2) ? "odd" : "even" ?>">-->
        <li class="ui-selectee ui-widget-content">
            <?php echo $friend ?>
        </li>
        <?php endforeach;?>
    </ul>
</div>