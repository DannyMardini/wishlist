<div id="div_right_panel">
    <h1>Wishlist</h1>
    <div id="div_wishlist_div">
    <?php foreach ($wishlist_items as $wishlist_item): ?>
        <h3><a href="#"><?php echo $wishlist_item->getName(); ?></a></h3>
        <div>
            <p><?php echo "$".$wishlist_item->getPrice(); ?></p>
        </div>
    <?php        endforeach;?>
    </div>
</div>