<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div id="div_wishlist_div">
<?php foreach ($wishlist_items as $wishlist_item): ?>
    <h3><a href="#"><?php echo $wishlist_item->getName(); ?></a></h3>
    <div>
        <p><?php echo "$".$wishlist_item->getPrice(); ?></p>
    </div>
<?php        endforeach;?>
</div>
