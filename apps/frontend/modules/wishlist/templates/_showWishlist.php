<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div id="div_wishlist_div">
  <h3><a id="newWishLink" href="#">New wish..</a></h3>
  <div class="newWishBox">
    <form id="newWishForm" >
      <input type="text" name="newWishName" placeholder="Name"/>
      <input type="text" name="newWishPrice" placeholder="Price"/>
      <input type="text" name="newWishLink" placeholder="Link"/>
      <input type="submit" value="test"/>
    </form>
  </div>
<?php foreach ($wishlist_items as $wishlist_item): ?>
    <h3><a href="#"><?php echo $wishlist_item->getName(); ?></a></h3>
    <div>
        <p><?php echo "$".$wishlist_item->getPrice(); ?></p>
    </div>
<?php        endforeach;?>
</div>
