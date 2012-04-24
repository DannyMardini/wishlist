<?php
?>
<div id="div_shoppinglist_div">
    <ul>
    <?php foreach($purchasedItems as $purchasedItem):?>
        <li><?php echo $purchasedItem->getName()?></li>
    <?php endforeach; ?>
    </ul>
</div>