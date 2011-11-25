<?php
use_stylesheet("friendlist.css");

//$friends = array("Andrea", "Steve", "Ryan");
?>

<script>
    $(function() {
       $( "#selectable" ).selectable();

    });
</script>


<div id="friendlist">
    <p>Friends:</p>
    <ul id="selectable">
        <?php foreach ($friends as $i => $friend): ?>
        <li class="<?php echo fmod($i, 2) ? "odd" : "even" ?>">
                <?php echo $friend ?>
        </li>
        <?php endforeach;?>
    </ul>
</div>